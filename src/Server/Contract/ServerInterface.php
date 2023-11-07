<?php namespace Visiosoft\TransferModule\Server\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

interface ServerInterface extends EntryInterface
{
    public function getServerName();

    public function getServerIP();

    public function getServerSSHPort();

    public function getServerSSHUsername();

    public function getServerSSHPassword();

    public function getDirectorySchema();

    public function getServerDatabaseRootUsername();

    public function getServerDatabaseRootPassword();
}
