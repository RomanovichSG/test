FROM mysql:5.7

FROM centos:centos7

RUN yum -y update\
    && services="\
        https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm\
        http://rpms.remirepo.net/enterprise/remi-release-7.rpm\
        yum-utils\
        git\
        unzip\
    "\
    && yum -y install $services\
    && yum-config-manager --enable remi-php73\
    && modules="\
        php\
        php-gd\
        php-mysqlnd\
        php-dom\
        php-cli\
        php-fpm\
        php-json\
        php-common\
        php-mbstring\
        php-opcache\
        php-zip\
        php-curl\
        php-gmp\
        php-xml\
        php-xsl\
        php-mysqli\
        php-sqlite\
        php-mcrypt\
        php-bcmath\
        php-bz2\
        php-soap\
        php-amqp\
        php-igbinary\
        php-xdebug\
        php-posix\
    "\
    && yum -y install $modules\
    && cd /tmp\
    && curl -sS https://getcomposer.org/installer | php\
    && mv composer.phar /usr/local/bin/composer\
    && yum clean all\
    && rm -rf /var/cache/yum
