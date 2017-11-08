@extends('layouts.app')

@section('content')

    <div class="container grid-container">
        <div class="image">
            <img src="{{ asset('img/amologin.png') }}" alt="amo login">
        </div>
        <div>
            <h2>Hallo {{ $firstname }},</h2>
            <p>Welkom bij <strong>AMO login</strong>. Met je AMO-account kun je inloggen op alle apps van Applicatie- en mediaontwikkeling. Dit account bestaat naast je <strong>ROCWB</strong> account.</p>
        </div>

        <div class="links-container">
            @foreach($apps as $app)
                <?php $url = parse_url($app->redirect); ?>
                <a target="_blank" class="btn btn-outline-primary" href="{{ $url['scheme'].'://'.$url['host'] }}"><span>{{ $app->name }}</span></a>
            @endforeach
            <a target="_blank" class="btn btn-outline-danger" href="http://amo.rocks/rooster"><span>Rooster (ROCWB)</span></a>
            <a target="_blank" class="btn btn-outline-danger" href="http://amo.rocks/mail"><span>Schoolmail (ROCWB)</span></a>
            <a target="_blank" class="btn btn-outline-danger" href="http://amo.rocks/mysite"><span>Mysite (ROCWB)</span></a>
        </div>
        
            
        <div class="bordered">
            <h5>Mijn gegevens</h5>

            <div class="my-group">
                <p class="title">Inlog-code</p>
                <p class="con   tent">{{ $user->id }}</p>
            </div>
            <div class="my-group">
                <p class="title">Wachtwoord</p>
                <p class="content"><a href="/users/{{ $user->id }}/profile">aanpassen</a></p>
            </div>
            <div class="my-group">
                <p class="title">Volledige naam</p>
                <p class="content">{{ $user->name }}</p>
            </div>
            <div class="my-group">
                <p class="title">E-mailadres</p>
                <p class="content">{{ $user->email }}</p>
            </div>
            <div class="my-group">
                <p class="title">Type account</p>
                <p class="content"><?php echo ($user->type == 'teacher') ? 'Docent' : 'Student' ?></p>
            </div>
            <div class="my-group my-group-list">
                <p class="title">Groepen</p>
                <ul class="content">
                    @foreach($user->groups as $group)
                        <li>{{ $group->name }}</li>
                    @endforeach
                    @foreach($user->groupHistory as $group)
                        <li class="text-muted">{{ $group->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>    
    </div>
    

@endsection
