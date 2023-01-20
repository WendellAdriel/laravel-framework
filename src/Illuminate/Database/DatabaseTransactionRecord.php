<?php

namespace Illuminate\Database;

class DatabaseTransactionRecord
{
    /**
     * The name of the database connection.
     *
     * @var string
     */
    public $connection;

    /**
     * The transaction level.
     *
     * @var int
     */
    public $level;

    /**
     * The callbacks that should be executed after committing.
     *
     * @var array
     */
    protected $callbacks = [];

    /**
     * The callbacks that should be executed on rollback.
     *
     * @var array
     */
    protected $rollbackCallbacks = [];

    /**
     * Create a new database transaction record instance.
     *
     * @param  string  $connection
     * @param  int  $level
     * @return void
     */
    public function __construct($connection, $level)
    {
        $this->connection = $connection;
        $this->level = $level;
    }

    /**
     * Register a callback to be executed after committing.
     *
     * @param  callable  $callback
     * @return void
     */
    public function addCallback($callback)
    {
        $this->callbacks[] = $callback;
    }

    /**
     * Execute all of the callbacks.
     *
     * @return void
     */
    public function executeCallbacks()
    {
        foreach ($this->callbacks as $callback) {
            $callback();
        }
    }

    /**
     * Get all of the callbacks.
     *
     * @return array
     */
    public function getCallbacks()
    {
        return $this->callbacks;
    }

    /**
     * Register a callback to be executed on rollback.
     *
     * @param  callable  $callback
     * @return void
     */
    public function addRollbackCallback($callback)
    {
        $this->rollbackCallbacks[] = $callback;
    }

    /**
     * Execute all the rollback callbacks.
     *
     * @return void
     */
    public function executeRollbackCallbacks()
    {
        foreach ($this->rollbackCallbacks as $callback) {
            $callback();
        }
    }

    /**
     * Get all the rollback callbacks.
     *
     * @return array
     */
    public function getRollbackCallbacks()
    {
        return $this->rollbackCallbacks;
    }
}
