#! /bin/bash

set -xv

############## CONST ################
IHM_PATH="/var/www/html/Athena/web/file"
CONF_PATH="$IHM_PATH/webacces/upload"
CORE_PATH="/home/athena/Core"
FLAGS_PATH="$CORE_PATH/flags"
BLOCK_PATH="$FLAGS_PATH/block"
TMP_PATH="$IHM_PATH/webacces/tmp"

############ FILE ###################

File_Conf=$(ls $CONF_PATH)


sed 's/\s\+/\n/g' $CONF_PATH/$File_Conf > $CONF_PATH/tmp_$File_Conf
echo -e "\n" >> $CONF_PATH/tmp_$File_Conf

mv $CONF_PATH/tmp_$File_Conf $CONF_PATH/$File_Conf

################## TAB #################

declare -a ConfFlagsOutBlock=()

################### Prepa #####################

mv $FLAGS_PATH/*-* $BLOCK_PATH > /dev/null 2>&1

############################## In Block Conf ######################################
while read line
do
	if [[ $line =~ "[/block]" ]]; then
		find=true
		continue
	fi
	if [[ $line =~ "[/Flag]" ]]; then
		find=false
		continue
	fi
	if [[ $find ]]; then
		ConfFlagsOutBlock[${#ConfFlagsOutBlock[@]}]="$line"
	fi
done < $CONF_PATH/$File_Conf

for Flag in ${ConfFlagsOutBlock[@]}
do
	mv $BLOCK_PATH/$Flag $FLAGS_PATH > /dev/null 2>&1
done

rm $CONF_PATH/$File_Conf