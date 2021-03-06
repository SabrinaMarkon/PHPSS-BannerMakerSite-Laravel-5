@extends('layouts.admin.main')

@section('heading')


@stop


@section('pagetitle')

    Members

@stop


@section('content')

    <div class="form-page-small">
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="form-page-large">

        <div class="table-responsive">
                <!-- Registration Form -->
                    <h2>Create New Member Account</h2>
                {{ Form::open(array('route' => array('admin.members.store'), 'method' => 'POST', 'class' => 'form-horizontal form-page-small')) }}
                    <div class="form-group">
                         {{ Form::label('userid', 'UserID', array('class' => 'col-sm-2 control-label')) }}
                          <div class="col-sm-10">
                         {{ Form::text('userid', old('userid'), array('placeholder' => 'username')) }}
                         </div>
                     </div>
                    <div class="form-group">
                        {{ Form::label('password', 'Password', array('class' => 'col-sm-2 control-label')) }}
                        <div class="col-sm-10 padding5pxtop">
                            {{ Form::password('password', array('placeholder' => 'password')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('password_confirmation', 'Confirm', array('class' => 'col-sm-2 control-label')) }}
                        <div class="col-sm-10 padding5pxtop">
                            {{ Form::password('password_confirmation', array('placeholder' => 'confirm password')) }}
                        </div>
                    </div>
                     <div class="form-group">
                        {{ Form::label('firstname', 'First&nbsp;Name', array('class' => 'col-sm-2 control-label')) }}
                        <div class="col-sm-10">
                        {{ Form::text('firstname', old('firstname'), array('placeholder' => 'firstname')) }}
                        </div>
                     </div>
                    <div class="form-group">
                        {{ Form::label('lastname', 'Last&nbsp;Name', array('class' => 'col-sm-2 control-label')) }}
                        <div class="col-sm-10">
                        {{ Form::text('lastname', old('lastname'), array('placeholder' => 'lastname')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
                        <div class="col-sm-10">
                        {{ Form::text('email', old('email'), array('placeholder' => 'email')) }}
                        </div>
                    </div>
                    @if (!empty($adminpaypal))
                        <div class="form-group">
                            {{ Form::label('paypal', 'PayPal', array('class' => 'col-sm-2 control-label')) }}
                            <div class="col-sm-10">
                                {{ Form::text('paypal', old('paypal'), array('placeholder' => 'paypal')) }}
                            </div>
                        </div>
                    @endif
                    @if (!empty($adminpayza))
                        <div class="form-group">
                            {{ Form::label('payza', 'Payza', array('class' => 'col-sm-2 control-label')) }}
                            <div class="col-sm-10">
                                {{ Form::text('payza', old('payza'), array('placeholder' => 'payza')) }}
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <div class="col-sm-12"> <br>
                        {{ Form::submit('Add New Member', array('class' => 'btn btn-custom')) }}
                        {{ Form::close() }}
                        </div>
                     </div>
        </div>

        <div class="table-responsive">
            <h2>Member Accounts</h2>
            <table class="table table-striped table-hover table-condensed table-bordered text-center" id="membertable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>UserID</th>
                    <th>Password</th>
                    <th>Account</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Verified</th>
                    @if (!empty($adminpaypal))
                        <th>PayPal</th>
                    @endif
                    @if (!empty($adminpayza))
                        <th>Payza</th>
                    @endif
                    <th>Sponsor</th>
                    <th>IP</th>
                    <th>Signup Date</th>
                    <th>Last Login</th>
                    <th>Vacation</th>
                    <th>Commission</th>
                    <th>Edit</th>
                    <td>Email Verification</td>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($members as $member)

                    <?php
                    $signupdate = new DateTime($member->signupdate);
                    $signupdate = $signupdate->format('Y-m-d');
                    $lastlogin = new DateTime($member->lastlogin);
                    $lastlogin = $lastlogin->format('Y-m-d');
                    ?>
                    <tr>
                        {{ Form::open(array('route' => array('admin.members.update', $member->id), 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
                        <td>{{ $member->id }} </td>
                        <td>{{ $member->userid }} </td>
                        <td>{{ Form::text('savepassword', NULL) }} </td>
                        <td>
                            <select name="saveadmin">
                                <option value="1" @if($member->admin == 1) selected @endif>Admin</option>
                                <option value="0" @if($member->admin != 1) selected @endif>Member</option>
                             </select>
                         </td>
                        <td>{{ Form::text('savefirstname', $member->firstname) }} </td>
                        <td>{{ Form::text('savelastname', $member->lastname) }} </td>
                        <td>{{ Form::text('saveemail', $member->email) }} </td>
                        <td>
                            <select name="saveverified">
                                <option value="1" @if($member->verified == 1) selected @endif>Yes</option>
                                <option value="0" @if($member->verified != 1) selected @endif>No</option>
                            </select>
                        </td>
                        @if (!empty($adminpaypal))
                            <td>{{ Form::text('savepaypal', $member->paypal) }} </td>
                        @endif
                        @if (!empty($adminpayza))
                            <td>{{ Form::text('savepayza', $member->payza) }} </td>
                        @endif
                        <td>{{ Form::text('savereferid', $member->referid) }} </td>
                        <td>{{ Form::text('saveip', $member->ip) }} </td>
                        <td>{{ Form::text('savesignupdate', $signupdate) }} </td>
                        <td>{{ Form::text('savelastlogin', $lastlogin) }} </td>
                        <td>
                            <select name="savevacation">
                                <option value="1" @if($member->vacation == 1) selected @endif>Yes</option>
                                <option value="0" @if($member->vacation != 1) selected @endif>No</option>
                            </select>
                        </td>
                        <td>{{ Form::text('savecommission', $member->commission) }} </td>
                        <td>
                            {{ Form::submit('Save', array('class' => 'btn btn-custom skinny')) }}
                            {{ Form::close() }}
                        </td>
                        @if ($member->verified === '1')
                            <td>Verified</td>
                        @else
                            <td>
                                {{ Form::open(array('url' => 'admin/members/resend/' . $member->id, 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'resendform')) }}
                                {{ Form::submit('Resend', array('class' => 'btn btn-custom skinny', 'id' => 'resendbutton')) }}
                                {{ Form::close() }}
                            </td>
                        @endif
                        <td>
                            {{ Form::open(array('route' => array('admin.members.destroy', $member->id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'deleteform' . $member->id)) }}
                            {{ Form::button('Delete', array('class' => 'btn btn-custom skinny', 'id' => $member->id)) }}
                            {{ Form::close() }}
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <script>
        $('button').on('click', function(){
            var deleteid = $(this).attr('id');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to undo this action!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete this account!'
            }).then(function () {
                $('#deleteform' + deleteid).submit();
            }, function (dismiss) {
                // dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
                if (dismiss === 'cancel') {
                    swal(
                            'Cancelled',
                            'The account is safe :)',
                            'error'
                    ).then(function() {
                        $(this).css({ 'color' : '#ffffff'});
                    })
                }
            })
        })
    </script>

@stop


@section('footer')



@stop
