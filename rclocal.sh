#!/bin/bash
# simple shell script to install GOautodial and dependencies 
# put in ks.cfg %post section

# default variables
GOSRCDIR=/usr/src/goautodial
APPKONFPL="listener.pl"
ASTCFGDIR=/etc/asterisk
ASTRECDIR=/var/spool/asterisk
ASTERISKDB="asterisk"
ASTPERLFILE="asterisk-perl-0.08.tar.gz"
ASTPERLDIR=/usr/src/asterisk-perl-0.08
GOAUTODIALDB="goautodial"
GOCRMCFGFILE="goCRMAPISettings.php"
KAMAILIODIR=/etc/kamailio
KAMAILIOCONF="kamailio.cfg"
KAMAILIOLOGDIR=/var/log/kamailio
MARIADBLOGDIR=/var/log/mariadb
MYFQDN="vaglxc01.goautodial.com"
RTPENGINEDIR=/etc/rtpengine
RTPENGINECONF="rtpengine.conf"
WEBROOT=/var/www/html

# get IP address
IPADDRESS=$(ip -o addr show up primary scope global |
      while read -r num dev fam addr rest; do echo ${addr%/*}; done)
IPADDRESS=`echo $IPADDRESS | awk '{print $1}'`

# get network interface
#NETDEV=`ip route get 8.8.8.8 | head -1 | awk '{print $5}'`
#IPALIASADDR="10.0.3.10"
#NETDEVFILE="ifcfg-${NETDEV}"

# set ip alias for NIC
#cat >> /etc/sysconfig/network-scripts/${NETDEVFILE} << EOF
#IPADDR1="${IPALIASADDR}"
#EOF

# update IP address entries on Kamailio and RTPengine
sed -i "s/123.234.345.456/${IPADDRESS}/g" ${RTPENGINEDIR}/${RTPENGINECONF} 
sed -i "s/10.10.100.19/${IPADDRESS}/g" ${KAMAILIODIR}/${KAMAILIOCONF}
#sed -i "s/192.168.100.19/${IPALIASADDR}/g" ${KAMAILIODIR}/${KAMAILIOCONF}
sed -i "s/vaglxc01.goautodial.com/${IPADDRESS}/g" ${WEBROOT}/php/${GOCRMCFGFILE}

# restart RTPengine and iptables
systemctl restart ngcp-rtpengine
systemctl restart iptables

sed -i "s/localhost4.localdomain4/localhost4.localdomain4 ${MYFQDN}/g" /etc/hosts
#cat >> /etc/hosts << EOF
#${IPALIASADDR} ${MYFQDN}
#EOF

# create log dirs for Kamailio and MariaDB
mkdir -p ${MARIADBLOGDIR} ${KAMAILIOLOGDIR}
touch ${MARIADBLOGDIR}/mariadb.log ${KAMAILIOLOGDIR}/kamailio.log
chown mysql.mysql -R ${MARIADBLOGDIR}
chown kamailio.kamailio -R ${KAMAILIOLOGDIR}

# make sure MariaDB is running
systemctl status mariadb

if [ $? > 0 ]; then
	systemctl start mariadb
fi

# install SQL data
for sql in ${GOSRCDIR}/sql/*.sql; do
	mysql -u root < $sql;
done

# update settings
mysql -u root ${GOAUTODIALDB} -e "UPDATE settings SET value='${IPADDRESS}' WHERE value='vaglxc01.goautodial.com';"
mysql -u root ${ASTERISKDB} -e "UPDATE servers SET alt_server_ip='${IPADDRESS}';"
mysql -u root ${ASTERISKDB} -e "UPDATE servers SET recording_web_link='ALT_IP';"

# install asterisk-perl
cd /usr/src
tar zxvf ${GOSRCDIR}/${ASTPERLFILE}
cd ${ASTPERLDIR}
perl Makefile.PL
make all
make install

# fix Asterisk recordings directory permissions
chmod 755 ${ASTRECDIR}
chmod 755 ${ASTRECDIR}/monitorDONE

# install listener.pl to /usr/local/bin
cp -f ${GOSRCDIR}/${APPKONFPL} /usr/local/bin/

# remove firstboot file
rm -f /.firstboot
