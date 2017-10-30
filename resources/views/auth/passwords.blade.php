@extends('layouts.app')

@section('content')

    <div class="container pwd-container spaced-container">
        <div id="pwd-text">
            <h3>Tips voor een sterk wachtwoord</h3>
            <p>Voor je wachtwoord op Amologin gelden geen specifieke regels, het moet alleen sterk genoeg zijn. Dat bereik je vooral door een <em>lang</em> wachtwoord te kiezen. Een kort wachtwoord met vreemde tekens is minder veilig dan een lang wachtwoord.</p>
            <p>Een zin van willekeurige woorden is dus veiliger dan een kort wachtwoord met vreemde tekens. Bijvoorbeeld: <em>egelautokoekjesschaar</em> is veiliger dan <em>Ab$d1f</em>. Een zin is ook nog eens makkelijker te onthouden. Je wachtwoord wordt nog veiliger door aan een lang wachtwoord ook cijfers of leestekens toe te voegen.</p>
            <p>Wachtwoorden met bijvoorbeeld je naam, geboortedatum of deze voorbeelden zijn natuurlijk niet veilig.</p>

            <p>Lees ook dit stripje als je wachtwoord-veiligheid interessant vindt:</p>
        </div>
        <div id="pwd-comic">
            <img src="{{ asset('img/comic.png') }}" alt="comic">
            <p><small class="text-muted">Comic by <a href="https://xkcd.com/936/" target="_blank">xkcd.com</a>.</small></p>
        </div>
        <div id="pwd-logo">
            <img src="{{ asset('img/amologin.png') }}" alt="amologin">
        </div>
        

        
    </div>
            
    
@endsection