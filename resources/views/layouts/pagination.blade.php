@if ($paginator->hasPages())
    <!-- /.btn-group -->
    
    <div class="float-right">
    {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} из {{ $paginator->total() }}
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm">
          @if ($paginator->onFirstPage())
          <span class="disabled"><span><i class="fas fa-chevron-left"></i></span></span>
      @else
          <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i></a>
      @endif
        </button>
        <button type="button" class="btn btn-default btn-sm">
          @if ($paginator->hasMorePages())
          <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fas fa-chevron-right"></i></a>
      @else
          <span class="disabled"><span><i class="fas fa-chevron-right"></i></span></span>
      @endif
        </button>
      </div>
      <!-- /.btn-group -->
    </div>
    <!-- /.float-right -->
  </div>
  @endif 