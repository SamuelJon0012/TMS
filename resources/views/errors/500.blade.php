@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error - This usually happens when something unexpected has happened on the server'))
