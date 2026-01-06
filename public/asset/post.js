        $(document).ready(function() {
            var offset = 6;
            var limit = 6;
            var isLoading = false;

            $('#loadMoreBtn').click(function() {
                if (isLoading) {
                    return;
                }
                isLoading = true;
                $('#loadMoreText').hide();
                $('#loadingSpinner').show();
                $.ajax({
                    url: '/load-more-posts',
                    type: 'GET',
                    data: {
                        offset: offset,
                        limit: limit
                    },
                    success: function(response) {
                        $('.post-container').append(response);
                        offset += limit;
                        if (response.trim().length === 0) {
                            $('#loadMoreBtn').hide();
                        } else {
                            $('#loadMoreBtn').show();
                        }
                        isLoading = false;
                        $('#loadMoreText').show();
                        $('#loadingSpinner').hide();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        isLoading = false;
                        $('#loadMoreText').show();
                        $('#loadingSpinner').hide();
                    }
                });
            });
        });
        $(document).ready(function() {
            var offset = 2;
            var limit = 2;
            var isLoading = false;

            $('#loadMoreBtn2').click(function() {
                if (isLoading) {
                    return; 
                }
                isLoading = true;
                $('#loadMoreText').hide();
                $('#loadingSpinner').show();
                  var slug = $(this).data('slug');
                $.ajax({
                    url: '/load-more-detail',
                    type: 'GET',
                    data: {
                        offset: offset,
                        limit: limit,
                        data: slug
                    },
                    success: function(response) {
                        $('.post-detail').append(response);
                        offset += limit;
                        if (response.trim().length === 0) {
                            $('#loadMoreBtn2').hide();
                        } else {
                            $('#loadMoreBtn2').show();
                        }
                        isLoading = false;
                        $('#loadMoreText').show();
                        $('#loadingSpinner').hide();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        isLoading = false;
                        $('#loadMoreText').show();
                        $('#loadingSpinner').hide();
                    }
                });
            });
        });
        $(document).ready(function() {
            var offset = 6;
            var limit = 2;
            var isLoading = false;

            $('#loadMoreBtn3').click(function() {
                if (isLoading) {
                    return;
                }
                isLoading = true;
                $('#loadMoreText').hide();
                $('#loadingSpinner').show();
                  var slug = $(this).data('slug');
                $.ajax({
                    url: '/load-more-daerah',
                    type: 'GET',
                    data: {
                        offset: offset,
                        limit: limit,
                        data: slug
                    },
                    success: function(response) {
                        $('.post-detail').append(response);
                        offset += limit;
                        if (response.trim().length === 0) {
                            $('#loadMoreBtn3').hide();
                        } else {
                            $('#loadMoreBtn3').show();
                        }
                        isLoading = false;
                        $('#loadMoreText').show();
                        $('#loadingSpinner').hide();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        isLoading = false;
                        $('#loadMoreText').show();
                        $('#loadingSpinner').hide();
                    }
                });
            });
        });
function handleScroll() {
    var scrollY = window.scrollY;
    if (!isDesktop()) {
      document.querySelector('.navbar1').classList.add('d-none');
      document.querySelector('.navbar2').classList.remove('d-none');
      document.querySelector('.navbar3').classList.add('d-none');
    } else {
      if (scrollY >= 150) {
        document.querySelector('.navbar1').classList.add('d-none');
        document.querySelector('.navbar2').classList.remove('d-none');
      } else {
        document.querySelector('.navbar1').classList.remove('d-none');
        document.querySelector('.navbar2').classList.add('d-none');
      }
    }
  }
  function isDesktop() {
    return window.matchMedia("(min-width: 768px)").matches;
  }
  window.addEventListener('scroll', handleScroll);
  handleScroll();



