$(document).ready(function() {
    var currentPage = 1;

    $('.btn-show-more').click(function() {
        var $btn = $(this);
        const originalText = $btn.text();
        
        currentPage++;

        $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $btn.prop('disabled', true);

        $.ajax({
            url: '/comments',
            type: 'GET',
            dataType: 'json',
            data: {
                page: currentPage,
                post_id: $btn.data('post-id')
            },
            success: function(data) {
                data.data.forEach(function(comment) {
                    var newComment = `
                            <li class="comment">
                                <div class="vcard">
                                    <img src="https://themewagon.github.io/blogy/images/person_1.jpg" alt="Image placeholder" />
                                </div>
                                <div class="comment-body">
                                    <h3>${htmlEncode(comment.user.first_name)} ${htmlEncode(comment.user.last_name)}</h3>
                                    <div class="meta">${moment(comment.created_at).format('D [de] MMMM [de] YYYY [às] h:mma')}</div>
                                    <p>${htmlEncode(comment.comment, {SAFE_FOR_TEMPLATES: true})}</p>
                                </div>
                            </li>
                        `;
                    $('.comment-list').append(newComment);
                });

                if (!data.next_page_url) {
                    return $btn.hide();
                }
            },
            complete: function() {
                $btn.prop('disabled', false);
                $btn.html(originalText);
            }
        });
    });

    function htmlEncode(str) {
        return String(str).replace(/[^\w. ]/gi, function(c){
            return '&#'+c.charCodeAt(0)+';';
        });
    }
});