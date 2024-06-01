@echo off
cd /d C:\Projects\trade_logix
echo %DATE% %TIME%: Running save-daily-metrics >> C:\Projects\trade_logix\var\log\save_daily_metrics.log
symfony console app:save-daily-metrics >> C:\Projects\trade_logix\var\log\save_daily_metrics.log 2>&1
echo %DATE% %TIME%: Finished save-daily-metrics >> C:\Projects\trade_logix\var\log\save_daily_metrics.log
