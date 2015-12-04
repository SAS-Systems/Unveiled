#!/bin/bash

#########################################
# upload each php file via ftp
#########################################

# branch-dependent folder:
# $BRANCH is specified as a env-variable in the .travis.yml
#   --> extend this if necessary <--
case "$BRANCH" in
	'Backend-PHP-Stack')
		PFAD="php"
		;;
	'apiAdapter')
		PFAD="adapterTest"
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
	# $FTP_USER, $FTP_PASSWORD and $FTP_URL are enrypted env-variables
	curl --ftp-create-dirs -T "$FILE" -u $FTP_USER:$FTP_PASSWORD "$FTP_URL/$PFAD/$FILE";
done; # file