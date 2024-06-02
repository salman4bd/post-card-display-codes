function pcd_enqueue_assets() {
    ?>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            border-radius: 15px;
            border: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            max-height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .card-text {
            flex-grow: 1;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.form-control');

            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.classList.add('animate');
                });

                input.addEventListener('blur', () => {
                    input.classList.remove('animate');
                });
            });
        });
    </script>
    <?php
}
add_action('wp_head', 'pcd_enqueue_assets');

function pcd_display_post_cards($atts) {
    $atts = shortcode_atts(array(
        'posts_per_page' => 5,
    ), $atts, 'post_cards');

    $query = new WP_Query(array(
        'posts_per_page' => $atts['posts_per_page'],
    ));

    ob_start();

    if ($query->have_posts()) {
        echo '<div class="container mt-5"><div class="row">';
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <?php if (has_post_thumbnail()) { ?>
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                    <?php } ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php the_title(); ?></h5>
                        <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary mt-auto">Read More</a>
                    </div>
                </div>
            </div>
            <?php
        }
        echo '</div></div>';
        wp_reset_postdata();
    }

    return ob_get_clean();
}
add_shortcode('post_cards', 'pcd_display_post_cards');
