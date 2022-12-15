docker stop test01web
docker stop test01adm
docker stop test01db
docker rm test01web
docker rm test01adm
docker rm test01db
::docker image rm nginx:latest
::For /F %%A In ('docker images nginx -f "dangling=true" -q') Do docker image rm %%A
::if %1%==nocache docker builder prune -f --filter "label=cache=no"
:: docker rm $(docker images nginx -f "dangling=true" -q)
docker compose up -d
