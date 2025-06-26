@extends('layouts.app')

@section('content')

<div class="container mt-5 glassy full-edge">
    <div>
        <h5>Klassenlijst uit Osiris importeren</h5>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <p>
            Vanwege het ontbreken van een export functionaliteit in Osiris, moet je de gegevens via een browser-script
            extraheren. Dit script haalt de benodigde gegevens op en formatteert ze in een JSON structuur die je hieronder kunt plakken.
        </p>

        @if (session('notice'))
        <div class="alert alert-success">
            {{ session('notice') }}
        </div>
        @endif

        <div class="accordion"
             id="importWizard">
            <!-- Step 1 -->
            <div class="card">
                <div class="card-header"
                     id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseOne"
                                aria-expanded="true"
                                aria-controls="collapseOne">
                            Stap 1: Zet de groepen klaar
                        </button>
                    </h2>
                </div>

                <div id="collapseOne"
                     class="collapse show"
                     aria-labelledby="headingOne"
                     data-parent="#importWizard">
                    <div class="card-body">
                        <p>Zorg ervoor dat alle groepen correct zijn ingesteld voordat je doorgaat.</p>
                        <p>Klik op de onderstaande link om de groepen in te stellen:</p>
                        <a href="{{ route('groups.batch') }}"
                           target="_blank"
                           class="btn btn-primary">Groepen instellen</a>
                        <div class="mt-3">
                            <button class="btn btn-success"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapseTwo">Volgende</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="card">
                <div class="card-header"
                     id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseTwo"
                                aria-expanded="false"
                                aria-controls="collapseTwo">
                            Stap 2: Zoek in een nieuw tabblad de groepen op in Osiris
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo"
                     class="collapse"
                     aria-labelledby="headingTwo"
                     data-parent="#importWizard">
                    <div class="card-body">
                        <p>Open een nieuw tabblad en ga naar Osiris om de groepen op te zoeken.</p>
                        <div class="my-3">
                            <a class="btn btn-primary"
                               href="https://osiris.curio.nl"
                               target="_blank">Open Osiris</a>
                        </div>
                        <p>Zorg ervoor dat je de juiste filters gebruikt om de gewenste groepen te vinden:</p>
                        <img src="https://private-user-images.githubusercontent.com/2738114/422734641-8d863b42-c4a6-496a-b9b1-8716afb5a7e6.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3NDE5NjQ1MDAsIm5iZiI6MTc0MTk2NDIwMCwicGF0aCI6Ii8yNzM4MTE0LzQyMjczNDY0MS04ZDg2M2I0Mi1jNGE2LTQ5NmEtYjliMS04NzE2YWZiNWE3ZTYucG5nP1gtQW16LUFsZ29yaXRobT1BV1M0LUhNQUMtU0hBMjU2JlgtQW16LUNyZWRlbnRpYWw9QUtJQVZDT0RZTFNBNTNQUUs0WkElMkYyMDI1MDMxNCUyRnVzLWVhc3QtMSUyRnMzJTJGYXdzNF9yZXF1ZXN0JlgtQW16LURhdGU9MjAyNTAzMTRUMTQ1NjQwWiZYLUFtei1FeHBpcmVzPTMwMCZYLUFtei1TaWduYXR1cmU9Nzg1ZTMyMGY1YmViMWUwZTZhNTBjOGRmZWI3OWJkNmExMGNkMzgyNmI5YmEwZGE0YWUyYjg5NDcyZmU1ZWIzNyZYLUFtei1TaWduZWRIZWFkZXJzPWhvc3QifQ.gKuQSj4ZLZfdbzbBl4CoHwwpAVZSg-OhiVmDBfUet6w"
                             alt="Osiris groepen zoeken"
                             class="img-fluid">
                        <div class="mt-3">
                            <button class="btn btn-success"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapseThree">Volgende</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="card">
                <div class="card-header"
                     id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseThree"
                                aria-expanded="false"
                                aria-controls="collapseThree">
                            Stap 3: Open de eerste studentregel
                        </button>
                    </h2>
                </div>
                <div id="collapseThree"
                     class="collapse"
                     aria-labelledby="headingThree"
                     data-parent="#importWizard">
                    <div class="card-body">
                        <p>Klik op de eerste studentregel in de lijst om de details te bekijken.</p>
                        <div class="mt-3">
                            <button class="btn btn-success"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapseFour">Volgende</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="card">
                <div class="card-header"
                     id="headingFour">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseFour"
                                aria-expanded="false"
                                aria-controls="collapseFour">
                            Stap 4: Open de developer tools en kopieer het import script naar de console
                        </button>
                    </h2>
                </div>
                <div id="collapseFour"
                     class="collapse"
                     aria-labelledby="headingFour"
                     data-parent="#importWizard">
                    <div class="card-body">
                        <p>Open de developer tools in je browser (meestal F12 of rechtermuisknop > Inspecteren).</p>
                        <p>Ga naar het tabblad 'Console' en kopieer het onderstaande script:</p>
                        <a href="#"
                           class="btn btn-primary"
                           onclick="window.copyScript(event)">Kopieer script</a>
                        <pre class="bg-light p-3"><code>{{ $exportScript }}</code></pre>
                        <p>Plak dit script in de console en druk op Enter om het uit te voeren.</p>
                        <div class="mt-3">
                            <button class="btn btn-success"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapseFive">Volgende</button>
                        </div>

                        <script type="text/javascript">
                            window.copyScript = async function(event) {
                                    event.preventDefault();
                                    var script = document.querySelector('pre code');
                                    var range = document.createRange();
                                    range.selectNode(script);
                                    window.getSelection().removeAllRanges();
                                    window.getSelection().addRange(range);

                                    try {
                                        await navigator.clipboard.writeText(script.innerText);
                                    } catch (error) {
                                        console.error(error.message);
                                    }
                                }
                        </script>
                    </div>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="card">
                <div class="card-header"
                     id="headingFive">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseFive"
                                aria-expanded="false"
                                aria-controls="collapseFive">
                            Stap 5: Kopieer de resultaten
                        </button>
                    </h2>
                </div>
                <div id="collapseFive"
                     class="collapse"
                     aria-labelledby="headingFive"
                     data-parent="#importWizard">
                    <div class="card-body">
                        <p>Wacht tot het script klaar is met uitvoeren en kopieer de resultaten uit de console.</p>
                        <div class="mt-3">
                            <button class="btn btn-success"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapseSix">Volgende</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 6 - Form -->
            <div class="card">
                <div class="card-header"
                     id="headingSix">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseSix"
                                aria-expanded="false"
                                aria-controls="collapseSix">
                            Stap 6: Importeer de resultaten
                        </button>
                    </h2>
                </div>
                <div id="collapseSix"
                     class="collapse"
                     aria-labelledby="headingSix"
                     data-parent="#importWizard">
                    <div class="card-body">
                        <p><strong>Let op:</strong></p>
                        <ul>
                            <li>Gebruikers worden toegevoegd aan een klas als er nu een actieve klas met die naam is
                                (klassen worden niet automatisch aangemaakt). Toevoegen aan klassen die in de toekomst
                                actief worden kan met de <em>Fake date</em>, bijvoorbeeld alvast voor het volgende
                                schooljaar.</li>
                            <li>Als een gebruiker al bestaat wordt die aan de genoemde klas toegevoegd. Historische
                                klassen worden niet verwijderd, actieve klassen wel.</li>
                        </ul>

                        <form action="{{ route('users.import_upload') }}"
                              method="POST">
                            @csrf

                            <div class="form-group row">
                                <label for="import"
                                       class="col-sm-3 col-form-label">Osiris Export JSON *</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control input"
                                              name="import"
                                              id="import"
                                              rows="10"
                                              placeholder="Plak hier de JSON van de Osiris export"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fake_date"
                                       class="col-sm-3 col-form-label">Fake date</label>
                                <div class="col-sm-6">
                                    <input type="text"
                                           class="form-control input"
                                           name="fake_date"
                                           id="fake_date"
                                           placeholder="{{ date('d-m-Y') }}">
                                    <small class="form-text text-muted">Voeg gebruikers toe aan groepen die op
                                        bovenstaande datum actief zijn</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="csv"
                                       class="col-sm-3 col-form-label">Zoek gebruikers volgens</label>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <input type="radio"
                                           name="find_user_prefix"
                                           value="i"
                                           id="find_user_i"
                                           checked>
                                    <label class="m-0 pl-2 pr-3"
                                           for="find_user_i">i123456</label>
                                    <input type="radio"
                                           name="find_user_prefix"
                                           value="D"
                                           id="find_user_D">
                                    <label class="m-0 pl-2 text-muted"
                                           for="find_user_D">D123456 (legacy)</label>
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn btn-success"><i class="fa fa-upload"></i> Importeer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
