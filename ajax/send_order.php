<?php

if (!isset($_SESSION['user']) || !$_SESSION['user'] instanceof User) {
    die;
}