<link rel="stylesheet" href="{{ mix('css/members.css') }}">
<a href="/">Back to Register Form</a>
<div class="memberList">
    @foreach($members as $member)

        @if($member['photo'] === '')
            $member['photo'] = 'source/uploads/default-image.png';
        @endif

        <table class='member-table'>
        <tr>
            <td class='descr'>Photo</td>
            <td><img src='{{$member['photo']}}' alt='user photo'></td>
        </tr>
        <tr>
            <td class='descr'>Full Name</td>
            <td>{{$member['firstName']}} {{$member['lastName']}}</td>
        </tr>
        <tr>
            <td class='descr'>Report Subject</td>
            <td>{{$member['subject']}}</td>
        </tr>
        <tr>
            <td class='descr'>Email</td>
            <td><a href='mailto:{{$member['email']}}'>{{$member['email']}}</a></td>
        </tr>
    </table>
    @endforeach
</div>

<a style="position: fixed; bottom: 0; left: 0;" href="#">To the top</a>
