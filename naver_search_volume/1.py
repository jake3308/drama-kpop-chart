import json
import pymysql
import datetime

# MySQL 연결 설정
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    database='drama_ranking'
)

try:
    with connection.cursor() as cursor:
        # 여러 배우의 데이터를 가져오기 위한 쿼리
        cursor.execute("SELECT actor_name, previous_monthly_search_volumes FROM best_actor_male WHERE id IN (%s, %s, %s)", (271, 2, 3))
        actors = cursor.fetchall()

        for actor in actors:
            actor_name, previous_volumes_json = actor

            # 현재 날짜 가져오기
            current_date = datetime.datetime.now().strftime('%Y-%m-%d')

            if previous_volumes_json:
                # JSON 데이터를 파싱하여 리스트로 변환
                previous_volumes = json.loads(previous_volumes_json)
            else:
                previous_volumes = []

            # 새로운 검색량 및 날짜 추가 (여기서는 예시로 1300을 추가)
            new_entry = {"date": current_date, "volume": 1300}
            previous_volumes.append(new_entry)

            # JSON 형식으로 다시 변환하여 저장
            updated_volumes_json = json.dumps(previous_volumes)

            # 업데이트된 값을 데이터베이스에 저장
            cursor.execute("""
                UPDATE best_actor_male
                SET  = %s
                WHERE actor_name = %s
            """, (updated_volumes_json, actor_name))

            print(f"'{actor_name}'의 검색량 정보가 업데이트되었습니다.")

        # 변경 사항 커밋
        connection.commit()

finally:
    connection.close()
