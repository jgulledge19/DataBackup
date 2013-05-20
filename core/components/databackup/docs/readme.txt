--------------------
DataBackup
--------------------
Version: 1.1.6 pl
Date: 5/20/2013
Author: Joshua Gulledge and the php class is based on code from: Raul Souza Silva (raul.3k@gmail.com) http://www.phpclasses.org/browse/file/33388.html
License: GNU GPLv2 (or later at your option)

Description
    This is a simple extra (snippet) for MODX Revolution that will backup your MySQL database as one sql dump and then each table as a SQL dump.
    So if you had a custom extra that failed you can easily restore one or more tables that have been messed up.  This 
    snippet is meant to be used with CronManager: http://modx.com/extras/package/cronmanager.  If you can't use that extra then use it with
    getCache: http://modx.com/extras/package/getcache.  You can also back up all of you MySQL DBs with this script.  If you are using MSSQL 
    look at the source and it should be easy to make it work for MSSQL.

How to use
1. Install via the package manager
2. Set the databackup.folder setting to something that is behind your web root.  The default is core/components/databackup/dumps/
3. Set the purge time option (databackup.pruge) if you want this to be different, the default is 1814400, which is 21 days.
4. Set up Cron Manager: http://rtfm.modx.com/display/ADDON/CronManager and then Create a new job.  
5. Select the backup snippet and then select in minutes how often you would like this to run.  Every 24 hours is 1440 minutes.


How to use snippet with getCache:
See: http://www.jasoncoward.com/technology/2010/10/simple-content-caching-with-getcache.html for examples

This is a simple backup your site every 24 hours(assuming the page is visited) or less if you flush the cache.  It will also purge
the backups older then 21 days.

[[!getCache?
    &element=`backup`
    &cacheExpires=`86400`
]]

View complete docs: http://rtfm.modx.com/display/ADDON/Databackup             

WARNING
Becareful were you make the file path for the purge setting.  If you place this in an existing folder all 
files older then the purge date will be delete.  It is recommended that you create a new folder for your backups
that are behind the public web.
