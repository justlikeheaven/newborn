php dll:
https://github.com/phpredis/phpredis/downloads

redisԶ������
vim redis.conf
requirepass {***} #��������

#����redis
kill {redis pid}
redis-server 

#php auth��֤
$connect = $redis->connect($cfg['host'], $cfg['port'], $cfg['timeout']);
$cfg['password'] && $redis->auth($cfg['password']);

------------------------------------------------------------------------------
[���redis��չ]
1����װphpredis
wget https://github.com/nicolasff/phpredis/archive/2.2.4.tar.gz
�ϴ�phpredis-2.2.4.tar.gz��/usr/local/srcĿ¼
cd /usr/local/src #������������Ŀ¼
tar zxvf phpredis-2.2.4.tar.gz #��ѹ
cd phpredis-2.2.4 #���밲װĿ¼
/usr/local/php/bin/phpize #��phpize����configure�����ļ�
./configure --with-php-config=/usr/local/php/bin/php-config  #����
make  #����
make install  #��װ
��װ���֮�󣬳�������İ�װ·��
/usr/local/php/lib/php/extensions/no-debug-non-zts-20090626/

2������php֧��
vi /usr/local/php/etc/php.ini  #�༭�����ļ��������һ�������������
extension="redis.so"
:wq! #�����˳�

3  ��������
sudo service nginx restart
sudo /etc/init.d/php-fpm restart