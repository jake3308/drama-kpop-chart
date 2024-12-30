import json
import requests
import pymysql
import time

# 네이버 API에서 발급받은 클라이언트 ID와 시크릿
client_id = "gmqKz7cGEOq5O2UCfnMZ"
client_secret = "sqe3NNcFdn"

def update_actor_search_volume():
    # MySQL 연결 설정
    connection = pymysql.connect(
        host='localhost',
        user='root',
        password='',
        database='drama_ranking'
    )

    try:
        with connection.cursor() as cursor:
            # 각 테이블에 대한 쿼리 및 업데이트 문
            tables = {
                "best_actor_female": "actor_name",
                "best_subactor_female": "actor_name",
                "best_actor_male": "actor_name",
                "best_subactor_male": "actor_name"
            }
            
            for table, actor_column in tables.items():
                query = f"SELECT id, {actor_column}, previous_weekly_search_volumes FROM {table}"
                cursor.execute(query)
                actors = cursor.fetchall()

                for actor in actors:
                    actor_id, actor_name, previous_volumes_json = actor

                    # 배우 이름으로 네이버 검색 API 호출
                    url = f"https://openapi.naver.com/v1/search/blog.json?query={actor_name}"
                    headers = {
                        "X-Naver-Client-Id": client_id,
                        "X-Naver-Client-Secret": client_secret
                    }
                    response = requests.get(url, headers=headers)

                    if response.status_code == 200:
                        data = response.json()
                        current_weekly_search_volume = data.get("total", 0)
                        print(f"'{actor_name}'에 대한 현재 검색 결과 수: {current_weekly_search_volume}")

                        # 이전 검색량을 JSON에서 파싱
                        if previous_volumes_json:
                            previous_volumes = json.loads(previous_volumes_json)
                        else:
                            previous_volumes = []
                        
                        # 주간 검색량 계산
                        previous_weekly_search_volume = previous_volumes[-1] if previous_volumes else 0
                        weekly_search_volume = current_weekly_search_volume - previous_weekly_search_volume
                        print(f"'{actor_name}'에 대한 주간 검색량: {weekly_search_volume}")

                        # 검색량을 리스트에 추가 (최대 n개의 값만 유지)
                        previous_volumes.append(current_weekly_search_volume)
                        previous_volumes_json = json.dumps(previous_volumes)

                        # 주간 검색량과 현재 검색량을 업데이트
                        update_sql = f"""
                            UPDATE {table}
                            SET previous_weekly_search_volumes = %s,
                                current_weekly_search_volume = %s,
                                weekly_search_volume = %s
                            WHERE id = %s
                        """
                        cursor.execute(update_sql, (previous_volumes_json, current_weekly_search_volume, weekly_search_volume, actor_id))

                        print(f"'{actor_name}'의 주간 검색량이 {table} 테이블에 업데이트되었습니다.")
                    else:
                        print(f"'{actor_name}'에 대한 검색 중 오류 발생: {response.status_code}")

                    time.sleep(1)

        # 변경 사항 저장
        connection.commit()
        print("모든 변경 사항이 데이터베이스에 커밋되었습니다.")

    finally:
        connection.close()
        print("데이터베이스 연결이 종료되었습니다.")

# 주간 검색량 업데이트 실행
update_actor_search_volume()
