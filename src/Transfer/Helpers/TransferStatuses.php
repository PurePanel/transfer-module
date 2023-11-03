<?php

namespace Visiosoft\TransferModule\Transfer\Helpers;

use MyCLabs\Enum\Enum;

class TransferStatuses extends Enum
{

    /**
     * @method static self TRANSFER_STARTING()
     * @method static self TARGET_SSH_CREDENTIALS_INVALID()
     * @method static self SOURCE_SSH_CREDENTIALS_INVALID()
     * @method static self LOGIN_WITH_RSA_CHECKING()
     * @method static self LOGIN_WITH_RSA_SUCCESS()
     * @method static self LOGIN_WITH_RSA_FAIL()
     * @method static self TARGET_ID_RSA_EXISTENCE_CHECKING()
     * @method static self TARGET_ID_RSA_NOT_FOUND()
     * @method static self TARGET_ID_RSA_FOUND()
     * @method static self ID_RSA_TRANSFER_STARTED()
     * @method static self ID_RSA_TRANSFERRED()
     * @method static self SQL_DUMP_STARTED()
     * @method static self SQL_DUMP_SUCCESS()
     * @method static self SQL_DUMP_FAILED()
     * @method static self DIRECTORY_TRANSFER_STARTED()
     * @method static self DIRECTORY_TRANSFERRED()
     * @method static self DIRECTORY_TRANSFER_FAILED()
     * @method static self SQL_IMPORT_STARTED()
     * @method static self SQL_IMPORTED()
     * @method static self SQL_IMPORT_FAILED()
     * @method static self SOURCE_SQL_CREDENTIALS_INVALID()
     * @method static self TARGET_SQL_CREDENTIALS_INVALID()
     * @method static self TRANSFER_COMPLETED()
     */

    public const TRANSFER_STARTING = 0;
    public const TARGET_SSH_CREDENTIALS_INVALID = 1;
    public const SOURCE_SSH_CREDENTIALS_INVALID = 2;
    public const LOGIN_WITH_RSA_CHECKING = 3;
    public const LOGIN_WITH_RSA_SUCCESS = 4;
    public const LOGIN_WITH_RSA_FAILED = 5;
    public const TARGET_ID_RSA_EXISTENCE_CHECKING = 6;
    public const TARGET_ID_RSA_NOT_FOUND = 7;
    public const TARGET_ID_RSA_FOUND = 8;
    public const ID_RSA_TRANSFER_STARTED = 9;
    public const ID_RSA_TRANSFERRED = 10;
    public const SQL_DUMP_STARTED = 11;
    public const SQL_DUMP_SUCCESS = 12;
    public const SQL_DUMP_FAILED = 13;
    public const DIRECTORY_TRANSFER_STARTED = 14;
    public const DIRECTORY_TRANSFERRED = 15;
    public const DIRECTORY_TRANSFER_FAILED = 16;
    public const SQL_IMPORT_STARTED = 17;
    public const SQL_IMPORTED = 18;
    public const SQL_IMPORT_FAILED = 19;
    public const SOURCE_SQL_CREDENTIALS_INVALID = 20;
    public const TARGET_SQL_CREDENTIALS_INVALID = 21;
    public const TRANSFER_COMPLETED = 22;
}