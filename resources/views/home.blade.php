@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-7">
            <div class="glassy full-edge">
                <div>
                    <h2 style="font-family: 'Franklin', 'Open Sans', sans-serif;">Hallo {{ $firstname }},</h2>
                    <p>Met je <strong>i-account</strong> van <strong>curio.codes</strong> kun je inloggen op alle apps van de
                        curio software-opleidingen. Dat zijn websites die eindigen op <em>curio.codes</em> (of het oude
                        <em>amo.rocks</em>). Dit account bestaat naast je <strong>edu-account</strong> account dat je van curio
                        krijgt.
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <div class="links-container">
                    <a target="_blank"
                    class="button min-w-fit"
                    href="http://student.curio.nl/">
                        Naar mijn edu-account
                        <i class="fa fa-fw fa-external-link"></i>
                    </a>
                    @foreach($apps as $app)
                    <?php $url = parse_url($app->redirect); ?>
                    <a target="_blank"
                    class="button min-w-fit"
                    href="{{ $url['scheme'].'://'.$url['host'] }}">
                        {{ $app->name }}
                        <i class="fa fa-fw fa-cube"></i>
                    </a>
                    @endforeach
                    @foreach($links as $link)
                    <a target="_blank"
                    class="button min-w-fit"
                    href="http://curio.codes/{{ $link->short }}">
                        {{ $link->title ?? ucfirst($link->short) }}
                        <i class="fa fa-fw fa-external-link"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="glassy full-edge">
                <h5>Mijn gegevens</h5>

                <div class="my-group">
                    <p class="title">I-account</p>
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
                    <p class="content">
                        <?php echo ($user->type == 'teacher') ? 'Docent' : 'Student' ?>
                    </p>
                </div>
                <div class="my-group">
                    <p class="title">Edu-account</p>
                    <p class="content"><a href="http://student.curio.nl/"
                        target="_blank">naar mijn edu-account</a></p>
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
    </div>
</div>

@endsection
