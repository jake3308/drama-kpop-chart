import pymysql

# MySQL 연결 설정
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    database='drama_ranking'
)




# None 값을 NULL로 변환하는 함수
def replace_none_with_null(drama_tuple):
    return tuple(None if value is None else value for value in drama_tuple)

# 드라마 정보를 담은 리스트 (각각의 드라마 정보는 튜플로 구성)
drama_info_list = [
    ("기생수: 더 그레이", "Parasyte: The Grey", "웹플랫폼", 6, "19+", "일시", "2024-04-05", None, None, "NETFLIX", None, "클라이맥스 스튜디오, 와우포인트", None, "SF, 액션, 스릴러, 호러, 생존, 다크 판타지, 느와르, 어드벤처, 고어, 크리처, 바디 스내처", None,100,7.1, 85.08,"구교환", "전소니, 이정현", "권해효, 김인권, 이현균, 도용구, 황인무, 이요섭", "윤현길, 문주연", "연상호", "연상호, 류용재"),
    ("브랜딩 인 성수동", "Branding in Seongsu", "웹플랫폼", 12, "15+", "순차", "2024-02-05", "2024-03-14", None, "U+모바일tv", None, "STUDIO X+U, STUDIO VPLUS, HIGROUND", None, "오피스, 로맨스, 미스터리", None, None,None,90.00, "로몬", "김지은, 양혜지", None, "정이랑, 채수아, 안연홍", "정헌수", None),
    ("닭강정", "Chicken Nugget", "웹플랫폼", 10, "15+", "일시", "2024-03-15", None, None, "NETFLIX", None, "스튜디오N, 플러스미디어엔터테인먼트", None, "블랙 코미디, SF, 스릴러, 판타지, 미스터리", 5.1, 70.95, None, "류승룡, 안재홍", "김유정", "김남희, 유승목, 정승길, 진영, 김태훈, 정순원, 양현민", "황미영", "이병헌", None),
    ("재즈처럼", "Jazz for Two", "웹플랫폼", 8, "15+", "순차", "2024-03-27", "2024-04-17", None, "WAVVE", "TVING, WATCHA", "IPQ, 엠오디티스튜디오", None, "BL, 멜로, 로맨스, 청소년 드라마, 성장물", 7.3, 91.67, None, "지호근, 진권, 한겸, 김정하", None, "성태, 고재현", "김민아", "송수림", None),
    ("리뷰왕 장봉기", "Mr. Review", "웹플랫폼", 7, "12+", "일시", "2024-03-29", None, None, "WATCHA", "WAVVE, TVING", "21스튜디오, 스튜디오SAG", None, "드라마, 코미디", None, 95.83, None, "김종구, 한세진, 송철호, 김용태", "가요이, 오민애, 서수민", None, "신기헌", "신기헌, 정주현", None),
    ("트리거", "Unmasked", "웹플랫폼", None, None, "일시", None, None, None, "Disney+", None, None, None, None, None, None, None, None, None, None, None, None, None, None),
    ("이사장님은9등급", None, "웹플랫폼", 12, "19+", "순차", "2024-04-29", "2024-06-03", None, "WAVVE", None, "로그인비피엠(빅픽처마트), 크로스마스", None, "학원, 청춘, 로맨스, 코미디, 스릴러", None, None, None, "문성현, 현석, 김원훈, 이창호", "김시경, 최지혜, 이효빈", "김경민, 차준혁, 기현우", "이승주, 예수빈", "이영성", None)
    
]





try:
    with connection.cursor() as cursor:
        for drama in drama_info_list:
            drama = replace_none_with_null(drama)
            # 각 변수에 값 할당
            korean_name, english_name, type, episodes, age_rating, release_type, start_date, end_date, airing_days, main_channel, additional_channels, production_company, co_production, genre, viewership_rating, rotten_tomatoes, imdb_rating, kino_rating, main_actor_male, main_actor_female, supporting_actor_male, supporting_actor_female, director, writer = drama

            # 기존에 해당 드라마가 있는지 확인
            check_sql = "SELECT id FROM drama_ranking WHERE korean_name = %s"
            cursor.execute(check_sql, (korean_name,))
            result = cursor.fetchone()

            if result:
                print(f"{korean_name}이(가) 존재하여 업데이트합니다.")
                # 드라마가 이미 존재하는 경우 업데이트
                update_sql = """
                    UPDATE drama_ranking SET
                        english_name = %s,
                        type = %s,
                        episodes = %s,
                        age_rating = %s,
                        release_type = %s,
                        start_date = %s,
                        end_date = %s,
                        airing_days = %s,
                        main_channel = %s,
                        additional_channels = %s,
                        production_company = %s,
                        co_production = %s,
                        genre = %s,
                        viewership_rating = %s,
                        rotten_tomatoes = %s,
                        imdb_rating = %s,
                        kino_rating = %s,
                        main_actor_male = %s,
                        main_actor_female = %s,
                        supporting_actor_male = %s,
                        supporting_actor_female = %s,
                        director = %s,
                        writer = %s
                    WHERE korean_name = %s
                """
                cursor.execute(update_sql, (
                    english_name, type, episodes, age_rating, release_type, start_date, end_date, airing_days,
                    main_channel, additional_channels, production_company, co_production, genre, viewership_rating,
                    rotten_tomatoes, imdb_rating, kino_rating, main_actor_male, main_actor_female, supporting_actor_male,
                    supporting_actor_female, director, writer, korean_name
                ))
            else:
                print(f"{korean_name}이(가) 존재하지 않아 새로 추가합니다.")
                # 드라마가 존재하지 않는 경우 새로 삽입
                insert_sql = """
                    INSERT INTO drama_ranking (
                        korean_name, english_name, type, episodes, age_rating, release_type, start_date, end_date,
                        airing_days, main_channel, additional_channels, production_company, co_production, genre,
                        viewership_rating, rotten_tomatoes, imdb_rating, kino_rating, main_actor_male,
                        main_actor_female, supporting_actor_male, supporting_actor_female, director, writer
                    ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                """
                cursor.execute(insert_sql, (
                    korean_name, english_name, type, episodes, age_rating, release_type, start_date, end_date,
                    airing_days, main_channel, additional_channels, production_company, co_production, genre,
                    viewership_rating, rotten_tomatoes, imdb_rating, kino_rating, main_actor_male, main_actor_female,
                    supporting_actor_male, supporting_actor_female, director, writer
                ))

        # 변경 사항 커밋
        connection.commit()
        print("변경 사항이 성공적으로 커밋되었습니다.")

except Exception as e:
    print(f"오류 발생: {e}")

finally:
    connection.close()

