![Toolbar Example Image](http://i.imgur.com/6bn1h.png)

# ZFDebug - A debug bar for Zend Framework

This is my fork of the ZFDebug project. I have added some extra functionality and additional support for `Zend_Application`.
The original project is hosted [http://code.google.com/p/zfdebug/](here).

## Description

ZFDebug is a plugin for the Zend Framework for PHP5 written by Joakim Nygård. It provides useful debug information displayed in a small bar at the bottom of every page. ZFDebug has been renamed from Scienta ZF Debug Bar when moving from private hosting to googlecode. The original page for Scienta ZF Debug Bar remains available [http://jokke.dk/software/scientadebugbar](here).

Time spent, memory usage and number of database queries are presented at a glance. Additionally, included files, a listing of available view variables and the complete SQL command of all queries are shown in separate panels (shown configured with 2 database adapters):

## The available plugins at this point are:

* Cache: Information on Zend_Cache and APC.
* Database: Full listing of SQL queries and the time for each.
* Exception: Error handling of errors and exceptions.
* File: Number and size of files included with complete list.
* Html: Number of external stylesheets and javascripts. Link to validate with W3C.
* Memory: Peak memory usage, memory usage of action controller and support for custom memory measurements.
* Registry: Contents of Zend_Registry
* Time: Timing information of current request, time spent in action controller and custom timers. Also average, min and max time for requests.
* Variables: View variables, request info and contents of $COOKIE and $POST
