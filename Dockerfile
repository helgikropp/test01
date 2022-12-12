FROM nginx
ENV LC_ALL en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US.UTF-8
LABEL cache=no
#EXPOSE 8080/tcp
#COPY ./assets/nginx/mime.types /etc/nginx
#COPY ./assets/nginx/nginx.conf /etc/nginx
#COPY ./assets/logging.inc /etc/nginx/conf.d
COPY ./assets/vhost_test01.local.conf /etc/nginx/conf.d
#COPY ../test01/ /usr/share/nginx/html/test01/
COPY ./sessions /usr/share/nginx/html/test01/sessions
COPY ./public /usr/share/nginx/html/test01/public
COPY ./inc /usr/share/nginx/html/test01/inc
COPY ./src /usr/share/nginx/html/test01/src
#COPY ./assets/nginx/default.conf /etc/nginx/conf.d
RUN apt -y update && apt -y upgrade && \
apt -y install apt-transport-https lsb-release ca-certificates wget curl apt-utils && \
wget --no-check-certificate -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
sh -c 'echo "deb [trusted=yes] https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' && \
touch /etc/apt/apt.conf.d/99verify-peer.conf && \
echo >>/etc/apt/apt.conf.d/99verify-peer.conf "Acquire { https::Verify-Peer false }" && \
##apt update && \
apt -y install locales locales-all && \
apt -y install software-properties-common git && \
apt -y update && \
#apt install -y php8.1-{common,cli,fpm,json,curl,gd,intl,soap,bcmath,mbstring,mysql,zip,xml} && \
apt install -y php8.1 php8.1-common php8.1-cli php8.1-fpm php8.1-curl php8.1-gd php8.1-intl && \
apt install -y php8.1-soap php8.1-bcmath php8.1-mbstring php8.1-mysql php8.1-zip php8.1-xml && \
#apt install -y php8.1-xdebug php-xdebug && \
sed -i 's/listen.group = www-data/listen.group = nginx/' /etc/php/8.1/fpm/pool.d/www.conf && \
usermod -aG users nginx && \
apt -y install mc
ENTRYPOINT chmod 777 /usr/share/nginx/html/test01/sessions && /etc/init.d/php8.1-fpm start && nginx -c /etc/nginx/nginx.conf -g "daemon off;"
