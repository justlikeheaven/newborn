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