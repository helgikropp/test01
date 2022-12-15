# test01

Тестове завдання
Під Docker Desktop

http://localhost:8082 - сам сайт (docker package "test01web")
http://localhost:8081 - адмінка MySQL (host: 'test01_db', user: 'root', pass: 'example', base: 'test01')
                        (docker package "test01adm")
localhost:3607 - вхід в базу з OS (docker package "test01db")

Default users сайту:
- login: user   pass: puser
- login: admin  pass: padmin

build.cmd - пакетний командний файл Windows для збірки і запуску Docker-контейнерів
sh.cmd    - пакетний командний файл Windows для входу в файлову систему контейнера test01web