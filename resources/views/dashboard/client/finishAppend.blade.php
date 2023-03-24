@extends('layouts.appWithoutSidebar')

@section('content')
<div class="w-100 d-flex align-items-center justify-content-center" style="height:100vh" x-data="pageManager()" x-init="setup()">
    <h3>Процесс привязки закончен успешно, вы будете перенапрвавлены через <span x-text="timeLeft"></span> секунды</h3>
</div>

<script>
    function finishSelection(){
        window.opener.triggerRefresh();
        window.close();
    }
    function pageManager(){
        return {
            timeLeft:3,
            tick: function(){
                this.timeLeft = this.timeLeft - 1;
            },
            setup: function(){
                setInterval(this.tick.bind(this), 1000)
            }
        }
    }
    window.setTimeout(finishSelection, 3000);
</script>
@endsection