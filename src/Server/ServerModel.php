<?php namespace Visiosoft\TransferModule\Server;

use Visiosoft\TransferModule\Server\Contract\ServerInterface;
use Anomaly\Streams\Platform\Model\Transfer\TransferServerEntryModel;

class ServerModel extends TransferServerEntryModel implements ServerInterface
{
    /**
     * @return \Anomaly\Streams\Platform\Entry\EntryPresenter|mixed
     */
    public function getServerName()
    {
        return $this->server_name;
    }

    /**
     * @return \Anomaly\Streams\Platform\Entry\EntryPresenter|mixed
     */
    public function getServerIP()
    {
        return $this->server_ip;
    }

    /**
     * @return \Anomaly\Streams\Platform\Entry\EntryPresenter|mixed
     */
    public function getServerSSHPort()
    {
        return $this->server_ssh_port;
    }

    /**
     * @return \Anomaly\Streams\Platform\Entry\EntryPresenter|mixed
     */
    public function getServerSSHUsername()
    {
        return $this->server_ssh_username;
    }

    /**
     * @return \Anomaly\Streams\Platform\Entry\EntryPresenter|mixed
     */
    public function getServerSSHPassword()
    {
        return $this->server_ssh_password;
    }

    /**
     * @return \Anomaly\Streams\Platform\Entry\EntryPresenter|mixed
     */
    public function getDirectorySchema()
    {
        return $this->server_directory_schema;
    }

    /**
     * @return \Anomaly\Streams\Platform\Entry\EntryPresenter|mixed
     */
    public function getServerDatabaseRootUsername()
    {
        return $this->server_database_root_username;
    }

    /**
     * @return \Anomaly\Streams\Platform\Entry\EntryPresenter|mixed
     */
    public function getServerDatabaseRootPassword()
    {
        return $this->server_database_root_password;
    }
}
