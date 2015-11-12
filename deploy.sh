#!/bin/bash

#########################################
# upload each php file via ftp
#########################################

# branch-dependent folder:
#   --> extend if necessary <--
case "$BRANCH" in
	'Backend-PHP-Stack')
		PFAD="php"
		;;
#	'someBranch' | 'otherBranch')
#		PFAD = "common/folder/for/both/branches"
#		;;
	*)
		PFAD="test/php"
		;;
esac

# iterate over files and upload them with curl
cd Backend-PHP-Stack
for FILE in $(find . -type f)
do
	printf "\nupload $FILE to server at $PFAD/$FILE";
	curl --ftp-create-dirs -T "$FILE" -u $FTP_USER:$FTP_PASSWORD "$FTP_URL/$PFAD/$FILE";
done; # file