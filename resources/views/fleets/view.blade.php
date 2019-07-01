@extends('layouts.grids.4-8')
@section('title', 'Home')
@section('content_header')
    <h1>TriglavDefense Fleets</h1>
@stop
@section('left')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3>{{$fleet['fleetname']}}</h3>
        </div>
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>FC</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Duration</th>

                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src='https://imageserver.eveonline.com/Character/{{ $fleet['fcid']}}_32.jpg' height='24' /></td>
                        <td>{{$fleet['fcname']}}</td>
                        <td>{{$fleet['started']}}</td>
                        @if($fleet['complete'])
                            <td>{{$fleet['ended']}}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{gmdate('H:i:s',$fleet['duration'])}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3>Participants</h3>
        </div>
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>Member</th>
                    <th>Duration</th>
                    @if(isset($fleet['loot']))
                        <th>Payout</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @if($punchlist)
                    @foreach($punchlist as $punch)
                        <tr>
                        <td><img src='https://imageserver.eveonline.com/Character/{{ $punch['userID'] }}_32.jpg' height='24' /></td>
                        <td>{{$punch['userName']}}</td>
                        <td>{{gmdate('H:i:s',$punch['duration'])}}</td>
                            @if(isset($fleet['loot']))
                            <td>{{  number_format(($fleet['loot']['totals']['buy'] * (1/$fleet['count']))  * (bcdiv($punch['duration'],$fleet['duration'],4))) }}</td>
                        @endif
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>
    </div>
@stop
@section('right')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3>Loot</h3>
            @if(!isset($fleet['loot']))
                <button type="button" class="btn btn-xs btn-box-tool" id="addLoot" data-toggle="modal" data-target="#addLootModal" data-placement="top" title="Add a new fitting">
                    <span class="fa fa-plus-square"></span>
                </button>
            @endif
        </div>
        <div class="box-body">
            <table class="table" id='lootlist'>
                <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Jita Buy</th>
                    <th>Total</th>

                </tr>
                </thead>
                <tbody>
                @if(isset($fleet['loot']))
                    @foreach($fleet['loot']['items'] as $loot)
                    <tr>
                        <td></td>
                        <td>{{$loot['name']}}</td>
                        <td>{{$loot['quantity']}}</td>
                        <td>{{number_format($loot['prices']['buy']['max'])}}</td>
                        <td>{{number_format($loot['prices']['buy']['max'] * $loot['quantity'])}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td>Total:</td>
                        <td></td>
                        <td></td>
                        <td>{{number_format($fleet['loot']['totals']['buy'])}}</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="addLootModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Are you sure?</h4>
                </div>
                <form role="form" action="{{ route('fleet.saveLoot', ['id' => $fleet['fleetid']]) }}" method="post">
                    <div class="modal-body">
                        <p>Cut and Paste Loot below</p>
                        {{ csrf_field() }}
                        <textarea name="loottext" id="loottext" rows="15" style="width: 100%"></textarea>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group pull-right" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input type="submit" class="btn btn-primary" id="saveloot" value="Submit Loot" />
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addLogModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Are you sure?</h4>
                </div>
                <form role="form" action="{{ route('fleet.saveLog', ['id' => $fleet['fleetid']]) }}" method="post">
                    <div class="modal-body">
                        <p>Cut and Paste Loot below</p>
                        {{ csrf_field() }}
                        <textarea name="fleetlog" id="fleetlog" rows="15" style="width: 100%"></textarea>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group pull-right" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input type="submit" class="btn btn-primary" id="savelog" value="Submit Log" />
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop
@push('js')
    <script type="text/javascript">
        let lootlist = $('#lootlist');



    </script>
@endpush