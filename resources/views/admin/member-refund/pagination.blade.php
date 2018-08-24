<!--{!! $arr->render() !!}-->
@if ($arr->hasPages())
  <ul class="pagination pagination">
    {{-- Previous Page Link --}}
    @if ($arr->currentPage()==1)
      <li class="disabled"><span>«</span></li>
    @else
      <li><a href="{{ $arr->previousPageUrl() }}" rel="prev">«</a></li>
    @endif

    <!--@if($arr->currentPage() < 3)
      <li class="<?php if($arr->currentPage()==1) echo 'active' ?>">
        <a href="{{ $arr->url(1) }}">1</a>
      </li>
    @endif-->

    @if($arr->lastPage()>3)
      @if($arr->currentPage()>2)
        @if($arr->currentPage()==$arr->lastPage())
          <li><a href="{{ $arr->url($arr->currentPage()-1) }}">
            {{ $arr->currentPage()-2 }}</a>
          </li>
          <li><a href="{{ $arr->url($arr->currentPage()-1) }}">
            {{ $arr->currentPage()-1 }}</a>
          </li>
          <li class="active"><span>{{ $arr->currentPage() }}</span></li>
        @else
          <li><a href="{{ $arr->url($arr->currentPage()-1) }}">
            {{ $arr->currentPage()-1 }}</a>
          </li>
          <li class="active"><span>{{ $arr->currentPage() }}</span></li>
          <li><a href="{{ $arr->url($arr->currentPage()+1) }}">
            {{ $arr->currentPage()+1 }}</a>
          </li>
        @endif
      @else 
        <li class="<?php if($arr->currentPage()==1) echo 'active' ?>">
          <a href="{{ $arr->url(1) }}">{{ 1 }}</a>
        </li>
        <li class="<?php if($arr->currentPage()==2) echo 'active' ?>">
          <a href="{{ $arr->url(2) }}">{{ 2 }}</a>
        </li>
        <li class="<?php if($arr->currentPage()==3) echo 'active' ?>">
          <a href="{{ $arr->url(3) }}">{{ 3 }}</a>
        </li>
      @endif 
    @else
      @foreach(range(1, $arr->lastPage()) as $i)
        @if ($i == $arr->currentPage())
          <li class="active"><span>{{ $i }}</span></li>
        @else
          <li><a href="{{ $arr->url($i) }}">{{ $i }}</a></li>
        @endif
      @endforeach
    @endif

    {{-- Next Page Link --}}
    @if ($arr->hasMorePages())
      <li><a href="{{ $arr->nextPageUrl() }}" rel="next">»</a></li>
    @else
      <li class="disabled"><span>»</span></li>
    @endif
  </ul>
@endif
