<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\File;

use Iterator;

/**
 * CSV File Iterator
 *
 * @author Jon LaBelle
 */
class CsvFileIterator implements Iterator {

    /**
     * Must be greater than the longest line (in characters) to be found in
     * the CSV file (allowing for trailing line-end characters).
     *
     * @var int
     */
    const ROW_LENGTH = 2048;

    /**
     * Resource file pointer
     */
    private $_handle;

    /**
     * Cumalitve row count of CSV data
     *
     * @var int
     */
    private $_key;

    /**
     * CSV column delimeter
     *
     * @var string
     */
    private $_delimiter;

    /**
     * CSV header file
     * 
     * @var array
     */
    private $_headers;

    /**
     * CSV current data
     * 
     * @var array data
     */
    private $_current;

    /**
     * Create an instance of the CsvFileIterator class.
     *
     * Throws InvalidArgumentException if CSV file (string $file)
     * does not exist.
     *
     * @param string $file The CSV file path.
     * @param string $delimiter The default delimeter is a single comma (,)
     */
    public function __construct($file, $delimiter = ',') {
        if (!file_exists($file)) {
            throw new InvalidArgumentException("{$file}");
        }
        $this->_handle = fopen($file, 'rt');
        $this->_delimiter = $delimiter;
    }

    /**
     * Read data current line
     * 
     * @return array data
     */
    public function readLine() {
        return fgetcsv($this->_handle, self::ROW_LENGTH, $this->_delimiter);
    }

    /*
     * @see Iterator::rewind()
     */

    public function rewind() {
        $this->_key = 0;
        return rewind($this->_handle);
    }

    /*
     * @see Iterator::current()
     */

    public function current() {
        $data = $this->readLine();
        if (!$data) {
            return false;
        }
        if ($this->_key == 0) {
            $this->_headers = $data;
            return $this->_headers;
        }
        $current = [];
        foreach ($data as $key => $value) {
            $current[$this->_headers[$key]] = $value;
        }
        return $current;
    }

    /*
     * @see Iterator::key()
     */

    public function key() {
        return $this->_key;
    }

    /*
     * @see Iterator::next()
     */

    public function next() {
        $this->_key++;
    }

    /*
     * @see Iterator::valid()
     */

    public function valid() {
        if (!feof($this->_handle)) {
            return true;
        }
        fclose($this->_handle);
        return false;
    }

}
