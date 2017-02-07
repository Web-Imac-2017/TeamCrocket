<?php
interface BucketInterface
{
    public function isNew() : bool;
    public function check();
}
