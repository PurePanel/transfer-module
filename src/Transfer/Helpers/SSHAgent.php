<?php

namespace Visiosoft\TransferModule\Transfer\Helpers;

use phpseclib3\Net\SSH2;

class SSHAgent
{
    private SSH2 $ssh;
    private string $ip;
    private string $port;
    private string $username;
    private string $password;

    public function __construct($ip, $port, $username, $password)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->ssh = new SSH2($this->ip, $this->port);

    }


    public function login(): bool
    {
        return $this->ssh->login($this->username, $this->password);
    }

    public function exec($command)
    {
        return $this->ssh->exec($command);
    }

    public function logout(): bool
    {
        return $this->exec('exit');
    }

    public function copyRsa($public): void
    {
        $this->write($public, '~/.ssh/authorized_keys');
    }

    ### Operationals ###
    public function cat($path): string
    {
        return $this->sudo() . " " . 'cat ' . $path;
    }

    public function touch($path): string
    {
        return $this->sudo() . " " . 'touch ' . $path;
    }

    public function mkdir($path): string
    {
        return $this->sudo() . " " . 'mkdir ' . $path;
    }

    public function sudo(): string
    {
        return 'echo ' . $this->password . ' | sudo -S sudo';
    }

    public function getDirectoryPermissionInfo($path)
    {
        return $this->exec($this->sudo() . ' ' . 'stat -c "%A %a %n" ' . $path);
    }

    public function chmod($level, $path, $isRecursive = true): string
    {
        $command = 'chmod';
        if ($isRecursive) {
            $command .= " -R";
        }
        $command .= " " . $level . " " . $path;
        return $this->exec($this->sudo() . " " . $command);
    }

    public function chown($username, $path, $isRecursive = true): string
    {
        $command = 'chown';
        if ($isRecursive) {
            $command .= " -R";
        }
        $command .= " " . $username . ":" . $username . " " . $path;
        return $this->exec($this->sudo() . " " . $command);
    }

    public function write($content, $path): string
    {
        return $this->exec($this->sudo() . ' ' . 'echo "' . $content . '" >> ' . $path);
    }


    ### RSA ###
    public function executeRsaCommand($type = 'private'): string
    {
        return $this->exec($this->cat($this->getIdRsaPath($type)));
    }

    public function checkIdRsaExistence(): bool
    {
        $pattern = "/BEGIN OPENSSH PRIVATE KEY/";
        $command = $this->executeRsaCommand();
        if (!preg_match($pattern, $command)) {
            return false;
        }

        return true;
    }

    public function getIdRsa(): string
    {
        $rsa = $this->executeRsaCommand();
        $pattern = "/(-----BEGIN OPENSSH PRIVATE KEY-----\s*(.*?)\s*-----END OPENSSH PRIVATE KEY-----)/s";
        preg_match($pattern, $rsa, $matches);
        return $matches[1];
    }

    public function getIdRsaPub(): string
    {
        $rsa = $this->executeRsaCommand('public');
        $pattern = "/(ssh-rsa\s+.+)/";
        preg_match($pattern, $rsa, $matches);

        if (!$matches) {
            return '';
        }

        return $matches[1];
    }

    public function getIdRsaPath($type = 'private'): string
    {
        $path = '~/.ssh/id_rsa';
        if ($type == "public") {
            $path .= ".pub";
        }

        return $path;
    }

    ##Sql Dump
    public function sqlDump($dbName, $dbUsername, $dbPassword, $fileName, $dumpDirectory)
    {
        $oldPermission = $this->extractNumericPermissions($this->getDirectoryPermissionInfo($dumpDirectory));
        $this->chmod(777, $this->removeTrailingSlash($dumpDirectory));

        $command = $this->sudo();
        $command .= ' mysqldump --host="localhost" --user=' . $dbUsername . ' --password=' . $dbPassword . ' ' . $dbName . ' > ' . $dumpDirectory . $fileName;

        $dump = $this->exec($command);
        $this->chmod($oldPermission, $this->removeTrailingSlash($dumpDirectory));

        return $dump;
    }

    public function sqlImport($database, $dbUsername, $dbPassword, $dumpPath)
    {

        $command = 'mysql -u ' . $dbUsername;

        if (!empty($dbPassword)) {
            $command .= ' -p' . $dbPassword;
        }

        $command .= ' -D ' . $database . ' < ' . $dumpPath;

        return $this->exec($command);
    }

    function removeTrailingSlash($inputString)
    {
        if (empty($inputString) || substr($inputString, -1) !== '/') {
            return $inputString;
        }
        return substr($inputString, 0, -1);
    }

    public function extractNumericPermissions($text): string
    {
        preg_match('/\d+/', $text, $matches);

        return $matches[0];
    }


}