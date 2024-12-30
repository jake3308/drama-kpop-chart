import json
import requests
import pymysql
import time

# 네이버 API에서 발급받은 클라이언트 ID와 시크릿
client_id = "gmqKz7cGEOq5O2UCfnMZ"
client_secret = "sqe3NNcFdn"

# 네이버 검색 API를 사용해 검색량을 가져오고 MySQL 데이터베이스에 업데이트하는 함수
def update_search_volume():
    # MySQL 연결 설정
    connection = pymysql.connect(
        host='localhost',
        user='root',
        password='',
        database='drama_ranking'
    )

    try:
        with connection.cursor() as cursor:
            # drama_ranking 테이블에서 드라마 이름(korean_name) 가져오기
            cursor.execute("SELECT id, korean_name, previous_search_volumes FROM drama_ranking")
            dramas = cursor.fetchall()

            for drama in dramas:
                drama_id, korean_name, previous_volumes_json = drama

                # 띄어쓰기를 무시하지 않은 검색량
                url_normal = f"https://openapi.naver.com/v1/search/blog.json?query={korean_name}"
                # 띄어쓰기를 무시한 검색량
                url_no_space = f"https://openapi.naver.com/v1/search/blog.json?query={korean_name.replace(' ', '')}"

                headers = {
                    "X-Naver-Client-Id": client_id,
                    "X-Naver-Client-Secret": client_secret
                }

                # API 요청 보내기 (띄어쓰기 무시하지 않은 경우)
                response_normal = requests.get(url_normal, headers=headers)
                response_no_space = requests.get(url_no_space, headers=headers)

                if response_normal.status_code == 200 and response_no_space.status_code == 200:
                    # 각각의 검색량 계산
                    data_normal = response_normal.json()
                    data_no_space = response_no_space.json()

                    search_volume_normal = data_normal.get("total", 0)
                    search_volume_no_space = data_no_space.get("total", 0)

                    # 두 검색량을 합산
                    current_search_volume = search_volume_normal + search_volume_no_space
                    print(f"'{korean_name}'에 대한 현재 주간 검색 결과 수: {current_search_volume}")

                    # 이전 검색량을 JSON에서 파싱
                    if previous_volumes_json:
                        previous_volumes = json.loads(previous_volumes_json)
                    else:
                        previous_volumes = []

                    # 주간 검색량 계산 (current_search_volume - previous_search_volume)
                    previous_search_volume = previous_volumes[-1] if previous_volumes else 0
                    search_volume = current_search_volume - previous_search_volume
                    print(f"'{korean_name}'에 대한 주간 검색량: {search_volume}")

                    # 검색량을 리스트에 추가 (최대 n개의 값만 유지)
                    previous_volumes.append(current_search_volume)
                    previous_volumes_json = json.dumps(previous_volumes)

                    # 주간 검색량과 현재 검색량을 업데이트
                    cursor.execute("""
                        UPDATE drama_ranking
                        SET previous_search_volumes = %s,
                            current_search_volume = %s,
                            search_volume = %s
                        WHERE id = %s
                    """, (previous_volumes_json, current_search_volume, search_volume, drama_id))

                    print(f"'{korean_name}'의 주간 검색량이 데이터베이스에 업데이트되었습니다.")
                else:
                    print(f"'{korean_name}'에 대한 검색 중 오류 발생: {response_normal.status_code} 또는 {response_no_space.status_code}")

                time.sleep(1)
        # 변경 사항 저장
        connection.commit()
        print("모든 변경 사항이 데이터베이스에 커밋되었습니다.")

    finally:
        connection.close()
        print("데이터베이스 연결이 종료되었습니다.")

# 주간 검색량 업데이트 실행
update_search_volume()
