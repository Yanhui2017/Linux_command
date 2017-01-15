#!/bin/sh
echo $PATH

# echo $?
# Logstash
/Users/lio/self/ELK/Logstash/logstash-5.1.1/bin/logstash -f /Users/lio/self/ELK/Logstash/logstash-5.1.1/log.logstash.conf

# Elasticsearch
/Users/lio/self/ELK/Elasticsearch/elasticsearch-5.1.1/bin/elasticsearch


# ls ./a
# if echo $? 
# then 
#     echo 123
# elif sh fog.sh
# then
#     echo 'real'
# else
#     echo '321'
# fi


