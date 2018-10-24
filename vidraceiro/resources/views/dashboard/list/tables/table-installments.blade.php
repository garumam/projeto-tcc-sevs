<table class="table table-hover">
    <thead>
    <tr class="tabela-aluminio">
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Cliente</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor da parcela</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Data de vencimento</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Venda Relacionada</th>
    </tr>
    </thead>
    <tbody>

    @foreach($installments as $installment)
        <tr>
            <th scope="row">{{$installment->id}}</th>
            @php
                $client = $installment->sale()->first()->budget()->first()->client()->first();
            @endphp
            <td>{{$client->nome}}</td>
            <td>{{$installment->valor_parcela}}</td>
            <td>{{date_format(date_create($installment->data_vencimento), 'd/m/Y')}}</td>

            <td>
                <a class="btn-link" target="_blank" href="{{ route('sales.show',['id'=> $installment->venda_id]) }}">
                    <button class="btn btn-light mb-1 card-shadow-1dp" type="button"
                            title="Ver venda relacionada a esta parcela"><i class="fas fa-eye"></i></button>
                </a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($installments->count() == 0) ? 'Nenhuma parcela pendente encontrada': ''}}</p>
{{ $installments->links('layouts.pagination') }}


