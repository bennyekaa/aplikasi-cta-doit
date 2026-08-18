@echo off
ipconfig ^| findstr /i "ipv4"
echo DONE
