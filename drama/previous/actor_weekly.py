import json
import pymysql

# MySQL 연결 설정
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    database='drama_ranking'
)

try:
    with connection.cursor() as cursor:
        # best_actor_male 테이블에서 특정 배우의 previous_search_volumes 가져오기
        cursor.execute("SELECT actor_name, previous_weekly_search_volumes FROM best_actor_male WHERE id = %s", (271,))
        actor = cursor.fetchone()

        if actor:
            actor_name, previous_volumes_json = actor

            if previous_volumes_json:
                # JSON 데이터를 파싱하여 리스트로 변환
                previous_volumes = json.loads(previous_volumes_json)

                print(f"'{actor_name}'의 이전 주간 검색량 기록:")
                for i, volume in enumerate(previous_volumes, start=1):
                    print(f"주 {i}: {volume}")
            else:
                print(f"'{actor_name}'의 이전 주간 검색량 데이터가 없습니다.")
        else:
            print("해당 배우를 찾을 수 없습니다.")

finally:
    connection.close()
