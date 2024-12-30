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
        # drama_ranking 테이블에서 특정 드라마의 previous_search_volumes 가져오기
        cursor.execute("SELECT korean_name, previous_search_volumes FROM drama_ranking WHERE id = %s", (2,))
        drama = cursor.fetchone()

        if drama:
            korean_name, previous_volumes_json = drama

            if previous_volumes_json:
                # JSON 데이터를 파싱하여 리스트로 변환
                previous_volumes = json.loads(previous_volumes_json)

                print(f"'{korean_name}'의 이전 주간 검색량 기록:")
                for i, volume in enumerate(previous_volumes, start=1):
                    print(f"주 {i}: {volume}")
            else:
                print(f"'{korean_name}'의 이전 주간 검색량 데이터가 없습니다.")
        else:
            print("해당 드라마를 찾을 수 없습니다.")

finally:
    connection.close()
