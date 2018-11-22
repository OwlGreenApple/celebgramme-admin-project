<!--{!! $order->render() !!}-->

@if ($order->hasPages())
  <ul class="pagination pagination">
    {{-- Previous Page Link --}}
    @if ($order->currentPage()==1)
      <li class="disabled"><span>«</span></li>
    @else
      <li><a href="{{ $order->previousPageUrl() }}" rel="prev">«</a></li>
    @endif

    @if($order->currentPage() < 3)
      <li class="<?php if($order->currentPage()==1) echo 'active' ?>">
        <a href="{{ $order->url(1) }}">1</a>
      </li>
    @endif

    @if($order->lastPage()>3)
      @if($order->currentPage()>2)
        @if($order->currentPage()==$order->lastPage())
          <li><a href="{{ $order->url($order->currentPage()-1) }}">
            {{ $order->currentPage()-2 }}</a>
          </li>
          <li><a href="{{ $order->url($order->currentPage()-1) }}">
            {{ $order->currentPage()-1 }}</a>
          </li>
          <li class="active"><span>{{ $order->currentPage() }}</span></li>
        @else
          <li><a href="{{ $order->url($order->currentPage()-1) }}">
            {{ $order->currentPage()-1 }}</a>
          </li>
          <li class="active"><span>{{ $order->currentPage() }}</span></li>
          <li><a href="{{ $order->url($order->currentPage()+1) }}">
            {{ $order->currentPage()+1 }}</a>
          </li>
        @endif
      @else 
        <li class="<?php if($order->currentPage()==2) echo 'active' ?>">
          <a href="{{ $order->url(2) }}">{{ 2 }}</a>
        </li>
        <li class="<?php if($order->currentPage()==3) echo 'active' ?>">
          <a href="{{ $order->url(3) }}">{{ 3 }}</a>
        </li>
      @endif 
    @else
      @foreach(range(1, $order->lastPage()) as $i)
        @if ($i == $order->currentPage())
          <li class="active"><span>{{ $i }}</span></li>
        @else
          <li><a href="{{ $order->url($i) }}">{{ $i }}</a></li>
        @endif
      @endforeach
    @endif

    {{-- Next Page Link --}}
    @if ($order->hasMorePages())
      <li><a href="{{ $order->nextPageUrl() }}" rel="next">»</a></li>
    @else
      <li class="disabled"><span>»</span></li>
    @endif
  </ul>
@endif
