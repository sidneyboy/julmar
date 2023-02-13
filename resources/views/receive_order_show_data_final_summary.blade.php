<div class="table table-responsive">
    @if ($discount_type == 'type_a')
        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Received</th>
                    <th>U/C</th>
                    <th>Discount</th>
                    <th>BO Discount</th>
                </tr>
            </thead>
        </table>
    @elseif($discount_type == 'type_b')
    @endif
</div>
