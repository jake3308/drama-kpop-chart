import requests
import pymysql
import time

# Google Custom Search API 설정
api_key = "AIzaSyCnCoYEz9H_QhGBEDyo-eY0QFLplLODoUw"  # Google API 키
search_engine_id = "e1988f8ed5b724534"  # Custom Search Engine ID


def get_google_search_volume(query):
    url = f"https://www.googleapis.com/customsearch/v1?q={query}&key={api_key}&cx={search_engine_id}"
    response = requests.get(url)

    if response.status_code == 200:
        data = response.json()
        total_results = data.get("searchInformation", {}).get("totalResults", 0)
        return int(total_results)
    else:
        print(f"Error: {response.status_code}")
        return 0

# MySQL 데이터베이스 연결
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    database='drama_ranking'
)

try:
    with connection.cursor() as cursor:
        # best_actor_male 테이블에서 배우 이름 가져오기
        cursor.execute("SELECT id, actor_name FROM best_actor_male")
        actors = cursor.fetchall()

        for actor in actors:
            actor_id, actor_name = actor

            # 배우 이름으로 구글 검색 API 호출
            current_monthly_search_volume = get_google_search_volume(actor_name)
            print(f"'{actor_name}'에 대한 현재 검색 결과 수: {current_monthly_search_volume}")

            # 배우의 검색량 정보를 업데이트
            cursor.execute("""
                UPDATE best_actor_male 
                SET current_monthly_search_volume = %s
                WHERE id = %s
            """, (current_monthly_search_volume, actor_id))

            print(f"'{actor_name}'의 검색량 정보가 데이터베이스에 업데이트되었습니다.")

            # API 사용량 제한을 고려하여 시간 지연 (예: 1초 지연)
            time.sleep(2)

        # best_actor_female 테이블에서 배우 이름 가져오기
        cursor.execute("SELECT id, actor_name FROM best_actor_female")
        actors = cursor.fetchall()

        for actor in actors:
            actor_id, actor_name = actor

            # 배우 이름으로 구글 검색 API 호출
            current_monthly_search_volume = get_google_search_volume(actor_name)
            print(f"'{actor_name}'에 대한 현재 검색 결과 수: {current_monthly_search_volume}")

            # 배우의 검색량 정보를 업데이트
            cursor.execute("""
                UPDATE best_actor_female 
                SET current_monthly_search_volume = %s
                WHERE id = %s
            """, (current_monthly_search_volume, actor_id))

            print(f"'{actor_name}'의 검색량 정보가 데이터베이스에 업데이트되었습니다.")

            # API 사용량 제한을 고려하여 시간 지연 (예: 1초 지연)
            time.sleep(2)

    # 변경 사항 저장
    connection.commit()
    print("모든 변경 사항이 데이터베이스에 커밋되었습니다.")

finally:
    connection.close()
    print("데이터베이스 연결이 종료되었습니다.")

