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

---------------------------------------redis�����ļ����---------------------------------------
redis��һ�Դ�ġ������ܵļ�-ֵ�洢��key-value store������memcached���ƣ�redis����������һ��key-value�ڴ�洢ϵͳ�����ڴ����ݿ⣬ͬʱ������֧�ַḻ�����ݽṹ���ֱ���Ϊһ�����ݽṹ��������data structure server����

������redis�����������ļ���Դ��Ŀ¼�� redis.conf  �����俽��������Ŀ¼�¼���ʹ�ã�����������redis.conf�еĸ���������


1 daemonize  no

Ĭ������£�redis �����ں�̨���еģ������Ҫ�ں�̨���У��Ѹ����ֵ����Ϊyes��

2 pidfile  /var/run/redis.pid

��Redis �ں�̨���е�ʱ��Redis Ĭ�ϻ��pid �ļ�����/var/run/redis.pid����������õ�������ַ�������ж��redis ����ʱ����Ҫָ����ͬ��pid �ļ��Ͷ˿�

3 port

�����˿ڣ�Ĭ��Ϊ6379

4 #bind 127.0.0.1

ָ��Redis ֻ���������ڸ�IP ��ַ������������������ã���ô��������������������������Ϊ�˰�ȫ������ø��Ĭ��ע�͵���������

5 timeout 0

���ÿͻ�������ʱ�ĳ�ʱʱ�䣬��λΪ�롣���ͻ��������ʱ����û�з����κ�ָ���ô�رո�����

6 tcp-keepalive 0

ָ��TCP�����Ƿ�Ϊ������,"��̽"�ź���server��ά����Ĭ��Ϊ0.��ʾ����

7 loglevel notice

log �ȼ���Ϊ4 ����debug,verbose, notice, ��warning������������һ�㿪��notice

8 logfile stdout

����log �ļ���ַ��Ĭ��ʹ�ñ�׼���������ӡ���������ն˵Ĵ����ϣ��޸�Ϊ��־�ļ�Ŀ¼

9 databases 16

�������ݿ�ĸ���������ʹ��SELECT �������л����ݿ⡣Ĭ��ʹ�õ����ݿ���0�ſ⡣Ĭ��16����

10 

save 900 1
save 300 10
save 60 10000

�������ݿ��յ�Ƶ�ʣ��������ݳ־û���dump.rdb�ļ��е�Ƶ�ȡ���������"�ڶ������ڼ����ٶ��ٸ��������"����snapshot���ݱ��涯��


Ĭ�����ã���˼�ǣ�

if(��60 ��֮����10000 ��keys �����仯ʱ){

���о��񱸷�

}else if(��300 ��֮����10 ��keys �����˱仯){

���о��񱸷�

}else if(��900 ��֮����1 ��keys �����˱仯){

���о��񱸷�

}

11 stop-writes-on-bgsave-error yes

���־û����ִ���ʱ���Ƿ���Ȼ�������й������Ƿ���ֹ���еĿͻ���write����Ĭ������"yes"��ʾ��ֹ��һ��snapshot���ݱ�����ϣ���ô��serverΪֻ���������Ϊ"no"����ô�˴�snapshot��ʧ�ܣ�����һ��snapshot�����ܵ�Ӱ�죬����������ֹ���,����ֻ�ָܻ���"���һ���ɹ���"

12 rdbcompression yes

�ڽ������ݾ��񱸷�ʱ���Ƿ�����rdb�ļ�ѹ���ֶΣ�Ĭ��Ϊyes��ѹ��������Ҫ�����cpu��֧���������ܹ���Ч�ļ�Сrdb�ļ��Ĵ������ڴ洢/����/����/���ݻָ�

13 rdbchecksum yes

��ȡ��д��ʱ�򣬻���ʧ10%����

14 rdbchecksum yes

�Ƿ����У��ͣ��Ƿ��rdb�ļ�ʹ��CRC64У���,Ĭ��Ϊ"yes"����ôÿ��rdb�ļ����ݵ�ĩβ����׷��CRCУ��ͣ����ڵ�����У�鹤�߼���ļ�������

14 dbfilename dump.rdb

���񱸷��ļ����ļ�����Ĭ��Ϊ dump.rdb

15 dir ./

���ݿ⾵�񱸷ݵ��ļ�rdb/AOF�ļ����õ�·���������·�����ļ���Ҫ�ֿ���������ΪRedis �ڽ��б���ʱ���ȻὫ��ǰ���ݿ��״̬д�뵽һ����ʱ�ļ��У��ȱ������ʱ���ٰѸ���ʱ�ļ��滻Ϊ������ָ�����ļ������������ʱ�ļ������������õı����ļ�����������ָ����·������

16 # slaveof <masterip> <masterport>

���ø����ݿ�Ϊ�������ݿ�Ĵ����ݿ⣬��Ϊ��ָ��master��Ϣ��

17 masterauth

�������ݿ�������Ҫ������֤ʱ��������ָ��

18 slave-serve-stale-data yes

����master�������һ������Ӹ����ڽ���ʱ���Ƿ���Ȼ��������ͻ����ʿ��ܹ��ڵ����ݡ���"yes"�����,slave������ͻ����ṩֻ������,�п��ܴ�ʱ�������Ѿ����ڣ���"no"����£��κ����server���͵������������(�����ͻ��˺ʹ�server��slave)��������֪"error"

19 slave-read-only yes

slave�Ƿ�Ϊ"ֻ��"��ǿ�ҽ���Ϊ"yes"

20 # repl-ping-slave-period 10

slave��ָ����master����ping��Ϣ��ʱ����(��)��Ĭ��Ϊ10

21 # repl-timeout 60

slave��masterͨѶ��,������ʱ��,Ĭ��60��.��ʱ���������ӹر�
22 repl-disable-tcp-nodelay no

slave��master������,�Ƿ����TCP nodelayѡ�"yes"��ʾ����,��ôsocketͨѶ�����ݽ�����packet��ʽ����(packet��С�ܵ�socket buffer����)��
�������socketͨѶ��Ч��(tcp��������),����С���ݽ��ᱻbuffer,���ᱻ��������,���ڽ����߿��ܴ����ӳ١�"no"��ʾ����tcp nodelayѡ��,�κ����ݶ��ᱻ��������,��ʱ�ԽϺ�,����Ч�ʽϵͣ�������Ϊno

23 slave-priority 100

����Sentinelģ��(unstable,M-S��Ⱥ����ͼ��),��Ҫ����������ļ�֧�֡�slave��Ȩ��ֵ,Ĭ��100.��masterʧЧ��,Sentinel�����slave�б����ҵ�Ȩ��ֵ���(>0)��slave,������Ϊmaster�����Ȩ��ֵΪ0,��ʾ��slaveΪ"�۲���",������masterѡ��

24 # requirepass foobared

���ÿͻ������Ӻ�����κ�����ָ��ǰ��Ҫʹ�õ����롣���棺��Ϊredis �ٶ��൱�죬������һ̨�ȽϺõķ������£�һ���ⲿ���û�������һ���ӽ���150K �ε����볢�ԣ�����ζ������Ҫָ���ǳ��ǳ�ǿ�����������ֹ�����ƽ⡣

25 # rename-command CONFIG 3ed984507a5dcd722aeade310065ce5d    (��ʽ:MD5('CONFIG^!'))

������ָ��,����һЩ��"server"�����йص�ָ��,���ܲ�ϣ��Զ�̿ͻ���(�ǹ���Ա�û�)��������ʹ��,��ô�Ϳ��԰���Щָ��������Ϊ"�����Ķ�"�������ַ���

26 # maxclients 10000

����ͬʱ���ӵĿͻ����������������������ֵʱ��redis �����ٽ��������������󣬿ͻ��˳�������ʱ���յ�error ��Ϣ��Ĭ��Ϊ10000��Ҫ����ϵͳ�ļ����������ƣ����˹����˷��ļ���������������ٸ��ݾ����������

27 # maxmemory <bytes>

redis-cache����ʹ�õ�����ڴ�(bytes),Ĭ��Ϊ0,��ʾ"������",������OS�����ڴ��С����(��������ڴ治��,�п��ܻ�ʹ��swap)����ֵ������Ҫ���������������ڴ�ߴ�,�����ܺ�ʵʩ�ĽǶȿ���,����Ϊ�����ڴ�3/4����������Ҫ��"maxmemory-policy"���ʹ��,��redis���ڴ����ݴﵽmaxmemoryʱ,����"�������"����"�ڴ治��"ʱ,�κ�write����(����set,lpush��)���ᴥ��"�������"��ִ�С���ʵ�ʻ�����,����redis���������������Ӳ�����ñ���һ��(�ڴ�һ��),ͬʱȷ��master/slave��"maxmemory""policy"����һ�¡�

���ڴ����˵�ʱ����������յ�set ���redis ���ȳ����޳����ù�expire ��Ϣ��key�������ܸ�key �Ĺ���ʱ�仹û�е����ɾ��ʱ��

�����չ���ʱ�����ɾ�������罫Ҫ�����ڵ�key �����ȱ�ɾ�����������expire ��Ϣ��key ��ɾ���ˣ��ڴ滹�����ã���ô�����ش���������redis �����ٽ���д����ֻ����get ����maxmemory �����ñȽ��ʺ��ڰ�redis ����������memcached�Ļ�����ʹ�á�

28 # maxmemory-policy volatile-lru

�ڴ治��"ʱ,�����������,Ĭ��Ϊ"volatile-lru"��

volatile-lru  ->��"���ڼ���"�е����ݲ�ȡLRU(��������ʹ��)�㷨.�����keyʹ��"expire"ָ��ָ���˹���ʱ��,��ô��key���ᱻ��ӵ�"���ڼ���"�С����Ѿ�����/LRU�����������Ƴ�.���"���ڼ���"��ȫ���Ƴ��Բ��������ڴ�����,��OOM.
allkeys-lru ->�����е�����,����LRU�㷨
volatile-random ->��"���ڼ���"�е����ݲ�ȡ"�漴ѡȡ"�㷨,���Ƴ�ѡ�е�K-V,ֱ��"�ڴ��㹻"Ϊֹ. ������"���ڼ���"��ȫ���Ƴ�ȫ���Ƴ��Բ�������,��OOM
allkeys-random ->�����е�����,��ȡ"���ѡȡ"�㷨,���Ƴ�ѡ�е�K-V,ֱ��"�ڴ��㹻"Ϊֹ
volatile-ttl ->��"���ڼ���"�е����ݲ�ȡTTL�㷨(��С���ʱ��),�Ƴ��������ڵ�����.
noeviction ->�����κθ��Ų���,ֱ�ӷ���OOM�쳣
���⣬������ݵĹ��ڲ����"Ӧ��ϵͳ"�����쳣,��ϵͳ��write�����Ƚ��ܼ�,�����ȡ"allkeys-lru"
29 # maxmemory-samples 3

Ĭ��ֵ3������LRU����СTTL���Բ����Ͻ��Ĳ��ԣ����Ǵ�Լ����ķ�ʽ����˿���ѡ��ȡ��ֵ�Ա���

29 appendonly no

Ĭ������£�redis ���ں�̨�첽�İ����ݿ⾵�񱸷ݵ����̣����Ǹñ����Ƿǳ���ʱ�ģ����ұ���Ҳ���ܺ�Ƶ��������redis �ṩ������һ�ָ��Ӹ�Ч�����ݿⱸ�ݼ����ѻָ���ʽ������append only ģʽ֮��redis ��������յ���ÿһ��д��������׷�ӵ�appendonly.aof �ļ��У���redis ��������ʱ����Ӹ��ļ��ָ���֮ǰ��״̬���������������appendonly.aof �ļ���������redis ��֧����BGREWRITEAOF ָ���appendonly.aof �����������������������������Ǩ�Ʋ������Ƽ����������µ�����Ϊ�رվ��񣬿���appendonly.aof��ͬʱ����ѡ���ڷ��ʽ��ٵ�ʱ��ÿ���appendonly.aof ������дһ�Ρ�

���⣬��master����,��Ҫ����д������ʹ��AOF,����slave,��Ҫ���������ѡ��1-2̨����AOF������Ľ���ر�
30 # appendfilename appendonly.aof

aof�ļ����֣�Ĭ��Ϊappendonly.aof

31 

# appendfsync always
appendfsync everysec
# appendfsync no

���ö�appendonly.aof �ļ�����ͬ����Ƶ�ʡ�always ��ʾÿ����д����������ͬ����everysec ��ʾ��д���������ۻ���ÿ��ͬ��һ�Ρ�no������fsync����OS�Լ�����ɡ������Ҫ����ʵ��ҵ�񳡾���������

32 no-appendfsync-on-rewrite no

��aof rewrite�ڼ�,�Ƿ��aof�¼�¼��append�ݻ�ʹ���ļ�ͬ������,��Ҫ���Ǵ���IO��֧����������ʱ�䡣Ĭ��Ϊno,��ʾ"���ݻ�",�µ�aof��¼��Ȼ�ᱻ����ͬ��
33 auto-aof-rewrite-percentage 100

��Aof log��������ָ������ʱ����дlog file�� ����Ϊ0��ʾ���Զ���дAof ��־����д��Ϊ��ʹaof���������С����ȷ�����������������ݡ�

34 auto-aof-rewrite-min-size 64mb

����aof rewrite����С�ļ��ߴ�

35 lua-time-limit 5000

lua�ű����е����ʱ��
36 slowlog-log-slower-than 10000

"��������־"��¼,��λ:΢��(�����֮һ��,1000 * 1000),�������ʱ�䳬����ֵ,�����command��Ϣ"��¼"����.(�ڴ�,���ļ�)������"����ʱ��"����������IO��֧,ֻ��������ﵽserver�����"�ڴ�ʵʩ"��ʱ��."0"��ʾ��¼ȫ������

37 slowlog-max-len 128

"��������־"�������������,"��¼"���ᱻ���л�,��������˴˳���,�ɼ�¼���ᱻ�Ƴ�������ͨ��"SLOWLOG <subcommand> args"�鿴����¼����Ϣ(SLOWLOG get 10,SLOWLOG reset)

38

 hash-max-ziplist-entries 512

hash���͵����ݽṹ�ڱ����Ͽ���ʹ��ziplist��hashtable��ziplist���ص�����ļ��洢(�Լ��ڴ�洢)����Ŀռ��С,�����ݽ�Сʱ,���ܺ�hashtable����һ��.���redis��hash����Ĭ�ϲ�ȡziplist�����hash����Ŀ����Ŀ��������value���ȴﵽ��ֵ,���ᱻ�ع�Ϊhashtable��

�������ָ����ziplist������洢�������Ŀ��������Ĭ��Ϊ512������Ϊ128
hash-max-ziplist-value 64

ziplist��������Ŀvalueֵ����ֽ�����Ĭ��Ϊ64������Ϊ1024

39 

list-max-ziplist-entries 512
list-max-ziplist-value 64

����list����,�����ȡziplist,linkedlist���ֱ������͡�����ͬ�ϡ�

40 set-max-intset-entries 512

intset��������������Ŀ����,����ﵽ��ֵ,intset���ᱻ�ع�Ϊhashtable

41 

zset-max-ziplist-entries 128
zset-max-ziplist-value 64

zsetΪ���򼯺�,��2�б�������:ziplist,skiplist����Ϊ"����"�������Ķ��������,��zset�����ݽ϶�ʱ,���ᱻ�ع�Ϊskiplist��

42 activerehashing yes

�Ƿ����������ݽṹ��rehash����,����ڴ�����,�뿪����rehash�ܹ��ܴ�̶������K-V��ȡ��Ч��

43 

client-output-buffer-limit normal 0 0 0
client-output-buffer-limit slave 256mb 64mb 60
client-output-buffer-limit pubsub 32mb 8mb 60

�ͻ���buffer���ơ��ڿͻ�����server���еĽ�����,ÿ�����Ӷ�����һ��buffer����,��buffer�������л��ȴ���client���ܵ���Ӧ��Ϣ�����client���ܼ�ʱ��������Ӧ��Ϣ,��ôbuffer���ᱻ���ϻ�ѹ����server�����ڴ�ѹ��.���buffer�л�ѹ�����ݴﵽ��ֵ,���ᵼ�����ӱ��ر�,buffer���Ƴ���

buffer�������Ͱ���:normal -> ��ͨ���ӣ�slave ->��slave֮������ӣ�pubsub ->pub/sub�������ӣ������͵����ӣ������������������;��Ϊpub�˻��ܼ��ķ�����Ϣ,����sub�˿������Ѳ���.
ָ���ʽ:client-output-buffer-limit <class> <hard> <soft> <seconds>",����hard��ʾbuffer���ֵ,һ���ﵽ��ֵ�������ر�����;
soft��ʾ"����ֵ",����seconds���,���bufferֵ����soft�ҳ���ʱ��ﵽ��seconds,Ҳ�������ر�����,���������soft������seconds֮��buffer����С����soft,���ӽ��ᱻ����.
����hard��soft������Ϊ0,���ʾ����buffer����.ͨ��hardֵ����soft.

44 hz 10

Redis serverִ�к�̨�����Ƶ��,Ĭ��Ϊ10,��ֵԽ���ʾredis��"��Ъ��task"��ִ�д���ԽƵ��(����/��)��"��Ъ��task"����"���ڼ���"��⡢�ر�"���г�ʱ"�����ӵ�,��ֵ�������0��С��500����ֵ��С����ζ�Ÿ����cpu��������,��̨task����ѯ�Ĵ�����Ƶ������ֵ������ζ��"�ڴ�����"�Խϲ�������Ĭ��ֵ��

45 

# include /path/to/local.conf
# include /path/to/other.conf

�������������ļ���