
@component('controls.modal',[
    'id'=>'patient-help-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
    ]
])
<h1 style="text-align:center;">TrackMy Vaccines Help</h1>

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <main role="main" class="inner cover">
        <div id="viewer-div" rel="/files/default/help.html?601da043ace03">
            <h3>Welcome to TrackMy Vaccines a feature of TrackMy Solutions&#153</h3>
            <p>At TrackMy we are focused on the Double E, Double I of Healthcare - E²i² (Engage, Educate, Inform, Involve), thus anything we can do to assist you with
                scheduling your vaccine appointment or ensuring your vaccination data is readily available to you, please do not hesitate to reach out.</p>

            <h2>Patient Call Center:  1-844-522-5952</h2>
            <p>9am-5pm 7 days a week EST</p>

        </div>
    </main>
</div>
@endcomponent