<style>
.table>:not(caption)>*>* {
    padding: .5rem .5rem;
    background-color: var(--bs-table-bg);
    border-bottom-width: 1px;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
}

tbody, td, tfoot, th, thead, tr {
    border-color: inherit;
    border-style: solid;
    border-width: 0;
}
td {
    display: table-cell;
    vertical-align: inherit;
}
.table {
    --bs-table-bg: transparent;
    --bs-table-striped-color: #212529;
    --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
    --bs-table-active-color: #212529;
    --bs-table-active-bg: rgba(0, 0, 0, 0.1);
    --bs-table-hover-color: #212529;
    --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
    width: 80%;
    margin-bottom: 1rem;
    color: #212529;
    vertical-align: top;
    border-color: #fff;
    margin: 100px auto;
}
table {
    caption-side: bottom;
    border-collapse: collapse;
    text-indent: initial;
    border-spacing: 2px;
}
body {
    margin: 0;
    font-family: var(--bs-font-sans-serif);
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    -webkit-text-size-adjust: 100%;
    -webkit-tap-highlight-color: transparent;
}
</style>

<h2 style="text-align: center; font-size: 30px; margin-top: 100px; margin-bottom: 0px;">Halal Business point BD</h2>
<small style="text-align: center; display: block;">Noyamati, Zilla markaz, Fatullah, Narayangonj, Bangladesh</small>

<table class="table">
    <thead>
        <tr>
            <td>Serial no.</td>
            <td>Invoice no.</td>
            <td>Product name</td>
            <td>Product quantity</td>
            <td>Product price</td>
            <td>Order date</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($order_details_infos as $order_details_info)
            <tr>
                <td>{{ $loop->index +1 }}</td>
                <td>{{ $order_details_info->order_id }}</td>
                <td>{{ $order_details_info->product->product_name }}</td>
                <td>{{ $order_details_info->product_quantity }}</td>
                <td>{{ $order_details_info->product_price }}</td>
                <td>{{ $order_details_info->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>