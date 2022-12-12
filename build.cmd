docker stop web
docker stop adminer
docker stop db
docker rm web
docker rm adminer
docker rm db
docker image rm mysql
docker image rm adminer
docker image rm nginx:latest
For /F %%A In ('docker images nginx -f "dangling=true" -q') Do docker image rm %%A
if %1%==nocache docker builder prune -f --filter "label=cache=no"
:: docker rm $(docker images nginx -f "dangling=true" -q)
docker compose up -d
