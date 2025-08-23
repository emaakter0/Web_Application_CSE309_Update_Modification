@echo off
setlocal enabledelayedexpansion

:: Set colors and title
color 0A
title Git Repository Manager

echo #############################################
echo #    Git Repository Setup - Smart Detector  #
echo #############################################
echo.

:: Ask for repository URL
set /p repo_url=Enter your GitHub repository URL (e.g., https://github.com/username/repo.git): 
if "!repo_url!"=="" (
    echo Error: Repository URL cannot be empty!
    pause
    exit /b 1
)

:: Ask for commit message
set /p commit_msg=Enter your commit message [default: "Initial commit"]: 
if "!commit_msg!"=="" set commit_msg="Initial commit"

echo.
echo Checking repository status...
echo =============================================

:: Check if this is a Git repo
git rev-parse --is-inside-work-tree >nul 2>&1
if %errorlevel% equ 0 (
    echo [Detected: Existing Git repository]
    goto EXISTING_REPO
) else (
    echo [Detected: New repository]
    goto NEW_REPO
)

:NEW_REPO
echo [1/6] Initializing new Git repository...
git init
if errorlevel 1 goto ERROR_INIT

:EXISTING_REPO
echo [2/6] Adding files to staging area...
git add .
if errorlevel 1 goto ERROR_ADD

echo [3/6] Committing changes: !commit_msg!...
git commit -m !commit_msg!
if errorlevel 1 goto ERROR_COMMIT

echo [4/6] Ensuring branch is named 'main'...
git branch -M main 2>nul || echo (Branch already 'main' or no changes)

echo [5/6] Setting remote origin...
git remote remove origin 2>nul
git remote add origin "!repo_url!"
if errorlevel 1 goto ERROR_REMOTE

echo [6/6] Pushing to remote repository...
git push -u origin main
if errorlevel 1 goto ERROR_PUSH

echo.
echo #############################################
echo #          Operation Completed!            #
echo # Repository successfully pushed to GitHub  #
echo #############################################
pause
exit /b 0

:ERROR_INIT
echo ERROR: Failed to initialize Git repository
pause
exit /b 1

:ERROR_ADD
echo ERROR: Failed to add files to staging area
pause
exit /b 1

:ERROR_COMMIT
echo ERROR: Failed to commit changes
pause
exit /b 1

:ERROR_REMOTE
echo ERROR: Failed to set remote origin
pause
exit /b 1

:ERROR_PUSH
echo ERROR: Failed to push to remote repository
echo Possible solutions:
echo 1. Check your internet connection
echo 2. Verify repository URL
echo 3. Pull changes first if repository exists
pause
exit /b 1