@extends('layouts.admin')

@section('content')
<h4> {{$varFY ?? ''}}- Admin</h4>
                             <div class="btn-controls">
                                <div class="btn-box-row row-fluid">
                                    <a href="#" class="btn-box big span4"><i class=" icon-random"></i><b>&#8377;</b>
                                        <p class="text-muted">
                                            Under construction</p>
                                    </a><a href="{{route('estbDonars')}}" class="btn-box big span4"><i class="icon-user"></i><b>{{ $countDoners }}</b>
                                        <p class="text-muted">
                                            Donars</p>
                                    </a><a href="{{route('estbCollection')}}" class="btn-box big span4"><i class="icon-money"></i><b>&#8377; {{$totalamount}}</b>
                                        <p class="text-muted">
                                            Collection</p>
                                    </a>
                                </div>
                                <div class="btn-box-row row-fluid">
                                    <div class="span8">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <a href="{{route('showAssignedrecieptbooks')}}" class="btn-box small span4"><i class="icon-envelope"></i><b>Reciept Books {{ $countRbooks ?? '' }}</b>
                                                </a><a href="#" class="btn-box small span4"><i class="icon-group"></i><b>Members/Donee {{ $countDonees ?? ''}} </b>
                                                </a><a href="{{route('getBankList')}}" class="btn-box small span4"><i class="icon-exchange"></i><b>Bank Deposits</b>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <a href="#" class="btn-box small span4"><i class="icon-save"></i><b>Registration</b>
                                                </a><a href="#" class="btn-box small span4"><i class="icon-bullhorn"></i><b>Social Activity</b>
                                                </a><a href="#" class="btn-box small span4"><i class="icon-sort-down"></i><b>Distribution</b> </a>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="widget widget-usage unstyled span4">
                                        <li>
                                            <p>
                                                <strong>Widows</strong> <span class="pull-right small muted">78%</span>
                                            </p>
                                            <div class="progress tight">
                                                <div class="bar" style="width: 78%;">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <p>
                                                <strong>Medical</strong> <span class="pull-right small muted">56%</span>
                                            </p>
                                            <div class="progress tight">
                                                <div class="bar bar-success" style="width: 56%;">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <p>
                                                <strong>Students</strong> <span class="pull-right small muted">44%</span>
                                            </p>
                                            <div class="progress tight">
                                                <div class="bar bar-warning" style="width: 44%;">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <p>
                                                <strong>Needy</strong> <span class="pull-right small muted">67%</span>
                                            </p>
                                            <div class="progress tight">
                                                <div class="bar bar-danger" style="width: 67%;">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            
                                               
 @endsection
