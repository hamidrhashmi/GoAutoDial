#!/bin/bash
# simple shell script to install GOautodial and dependencies 
# put in ks.cfg %post section

# default variables
GOSRCDIR=/usr/src/goautodial
AST13DATADIR=/usr/share/asterisk
ASTDATADIR=/var/lib/asterisk
ASTGUIDIR="astguiclient"
ASTGUICONF="astguiclient.conf"
CONFGSMFILE="conf.gsm"
GOCFGFILE="etc.tar"
GOHTMLFILE="html.tar"
OPUSCODEC="codec_opus.tar"
CRONDIR=/var/spool/cron
CRONROOT="root"
KAMAILIOLOGDIR=/var/log/kamailio
MARIADBLOGDIR=/var/log/mariadb
SELINUXDIR=/etc/selinux
WEBROOT=/var/www/html

# copy GOautodial web files to Apache's document root
cd /var/www
tar xvf ${GOSRCDIR}/${GOHTMLFILE} 2>/dev/null
chown apache.apache -R ${WEBROOT}

# copy default astguiclient.conf
cp -f ${WEBROOT}/${ASTGUICONF} /etc/

# install Astguiclient backend Perl scripts
mkdir -p ${ASTDATADIR}/{agi-bin,sounds,mohmp3,default}
chmod 777 ${ASTDATADIR}/sounds
rmdir  ${AST13DATADIR}/{agi-bin,sounds}
ln -sf ${ASTDATADIR}/agi-bin ${AST13DATADIR}/
ln -sf ${ASTDATADIR}/sounds ${AST13DATADIR}/

cd ${GOSRCDIR}/${ASTGUIDIR}
perl ./install.pl  --no-prompt --without-web --asterisk_version 13.X --copy_sample_conf_files 2>/dev/null
cp ${GOSRCDIR}/${CONFGSMFILE} ${ASTDATADIR}/sounds/
ln -s ${ASTDATADIR}/sounds/${CONFGSMFILE}  ${ASTDATADIR}/sounds/park.gsm

# install opus codec
cd /
tar xvf ${GOSRCDIR}/${OPUSCODEC} 
tar xvf ${GOSRCDIR}/${GOCFGFILE}

# install crontab for root
cp -f ${GOSRCDIR}/cron/${CRONROOT} ${CRONDIR}

# disable selinux
sed -i 's/SELINUX=enforcing/SELINUX=disabled/g' ${SELINUXDIR}/config

# set permissions for ssl certs
chmod 644 /etc/pki/tls/private/localhost.key
chmod 644 /etc/pki/tls/certs/localhost.crt

# create firstboot file
touch /.firstboot
