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
        # drama_ranking 테이블에서 남자 배우 정보와 검색량을 가져오기
        select_male_sql = """
            SELECT id, korean_name, search_volume, main_actor_male
            FROM drama_ranking
            WHERE main_actor_male IS NOT NULL
        """
        cursor.execute(select_male_sql)
        male_dramas = cursor.fetchall()

        # best_actor_male 테이블에 데이터를 삽입 또는 업데이트
        for drama in male_dramas:
            drama_id, korean_name, search_volume, main_actor_male = drama
            actor_names = main_actor_male.split(',')  # 배우 이름들을 ','로 분리

            for actor_name in actor_names:
                actor_name = actor_name.strip()  # 앞뒤 공백 제거

                # best_actor_male 테이블에 배우와 드라마 이름이 모두 겹치는지 확인
                select_sql = """
                    SELECT id FROM best_actor_male
                    WHERE drama_id = %s AND actor_name = %s
                """
                cursor.execute(select_sql, (drama_id, actor_name))
                result = cursor.fetchone()

                if result:
                    # 데이터가 존재하면 업데이트
                    update_sql = """
                        UPDATE best_actor_male
                        SET search_volume = %s
                        WHERE drama_id = %s AND actor_name = %s
                    """
                    cursor.execute(update_sql, (search_volume, drama_id, actor_name))
                else:
                    # 데이터가 없으면 삽입
                    insert_sql = """
                        INSERT INTO best_actor_male (drama_id, korean_name, search_volume, actor_name)
                        VALUES (%s, %s, %s, %s)
                    """
                    cursor.execute(insert_sql, (drama_id, korean_name, search_volume, actor_name))

        # drama_ranking 테이블에서 여자 배우 정보와 검색량을 가져오기
        select_female_sql = """
            SELECT id, korean_name, search_volume, main_actor_female
            FROM drama_ranking
            WHERE main_actor_female IS NOT NULL
        """
        cursor.execute(select_female_sql)
        female_dramas = cursor.fetchall()

        # best_actor_female 테이블에 데이터를 삽입 또는 업데이트
        for drama in female_dramas:
            drama_id, korean_name, search_volume, main_actor_female = drama
            actor_names = main_actor_female.split(',')  # 배우 이름들을 ','로 분리

            for actor_name in actor_names:
                actor_name = actor_name.strip()  # 앞뒤 공백 제거

                # best_actor_female 테이블에 배우와 드라마 이름이 모두 겹치는지 확인
                select_sql = """
                    SELECT id FROM best_actor_female
                    WHERE drama_id = %s AND actor_name = %s
                """
                cursor.execute(select_sql, (drama_id, actor_name))
                result = cursor.fetchone()

                if result:
                    # 데이터가 존재하면 업데이트
                    update_sql = """
                        UPDATE best_actor_female
                        SET search_volume = %s
                        WHERE drama_id = %s AND actor_name = %s
                    """
                    cursor.execute(update_sql, (search_volume, drama_id, actor_name))
                else:
                    # 데이터가 없으면 삽입
                    insert_sql = """
                        INSERT INTO best_actor_female (drama_id, korean_name, search_volume, actor_name)
                        VALUES (%s, %s, %s, %s)
                    """
                    cursor.execute(insert_sql, (drama_id, korean_name, search_volume, actor_name))

        # 변경 사항 커밋
        connection.commit()

finally:
    connection.close()
