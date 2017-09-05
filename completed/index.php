<?php

require "bootstrap/autoload.php";

use App\Model\Author;
use App\Model\Book;
use App\Model\Category;
use App\Model\Language;
use App\Model\Cover;
use App\Model\Location;
use App\Model\Year;

require "search.php";

$authors = (new Author)->authors();
$categories = (new Category)->categories();
$languages = (new Language)->languages();
$covers = (new Cover)->covers();
$locations = (new Location)->locations();
$years = (new Year)->years();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advanced Search Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="./assets/css/dist/app.css" rel="stylesheet">
</head>
<body>

    <div class="row">

        <div class="column">

            <form
                method="get"
                action="/"
                class="panel"
                >

                <div class="row">

                    <div class="large-4 medium-6 small-12 columns">
                        <label for="keyword">Search for:</label>
                        <input
                            type="text"
                            name="keyword"
                            id="keyword"
                            value="<?php echo $sticky->text('keyword'); ?>"
                            >
                    </div>
                    <div class="large-4 medium-6 small-12 columns">
                        <label for="category">Category:</label>
                        <select
                            name="category"
                            id="category"
                            >
                            <option value="">Any category</option>
                            <?php foreach($categories as $category) { ?>
                                <option
                                    value="<?php echo $category->id; ?>"
                                    <?php echo $sticky->select('category', $category->id); ?>
                                    ><?php echo $category->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="large-4 medium-6 small-12 columns">
                        <label for="author">Author:</label>
                        <select
                            name="author"
                            id="author"
                        >
                            <option value="">Any author</option>
                            <?php foreach($authors as $author) { ?>
                                <option
                                    value="<?php echo $author->id; ?>"
                                    <?php echo $sticky->select('author', $author->id); ?>
                                    ><?php echo $author->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>

                <div class="divider brtd"></div>

                <div class="row">

                    <div class="large-4 medium-6 small-12 columns">
                        <label for="year">Year:</label>
                        <select
                            name="year"
                            id="year"
                        >
                            <option value="">Any year</option>
                            <?php foreach($years as $year) { ?>
                                <option
                                    value="<?php echo $year->year; ?>"
                                    <?php echo $sticky->select('year', $year->year); ?>
                                    ><?php echo $year->year; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="large-4 medium-6 small-12 columns">
                        <label for="language">Language:</label>
                        <select
                            name="language"
                            id="language"
                        >
                            <option value="">Any language</option>
                            <?php foreach($languages as $language) { ?>
                                <option
                                    value="<?php echo $language->id; ?>"
                                    <?php echo $sticky->select('language', $language->id); ?>
                                    ><?php echo $language->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="large-4 medium-6 small-12 columns">
                        <label>Cover type:</label>
                        <ul class="inline-list">
                            <li>
                                <label for="cover_0">
                                    <input
                                        type="radio"
                                        name="cover"
                                        id="cover_0"
                                        value=""
                                        <?php echo $sticky->radio('cover', 0, 0); ?>
                                        > Any
                                </label>
                            </li>
                            <?php foreach($covers as $cover) { ?>

                                <li>
                                    <label for="cover_<?php echo $cover->id; ?>">
                                        <input
                                            type="radio"
                                            name="cover"
                                            id="cover_<?php echo $cover->id; ?>"
                                            value="<?php echo $cover->id; ?>"
                                            <?php echo $sticky->radio('cover', $cover->id); ?>
                                        > <?php echo $cover->name; ?>
                                    </label>
                                </li>

                            <?php } ?>
                        </ul>
                    </div>

                </div>

                <div class="divider brtd"></div>

                <label>Available in:</label>

                <ul class="inline-list">
                    <?php foreach($locations as $location) { ?>
                    <li>
                        <label for="location_<?php echo $location->id; ?>">
                            <input
                                type="checkbox"
                                name="location[]"
                                id="location_<?php echo $location->id; ?>"
                                value="<?php echo $location->id; ?>"
                                <?php echo $sticky->checkboxArray('location', $location->id); ?>
                            > <?php echo $location->name; ?>
                        </label>
                    </li>
                    <?php } ?>
                </ul>

                <div class="divider brtd"></div>

                <div class="row">

                    <div class="large-4 medium-6 small-12 columns large-offset-4 medium-offset-3">

                        <div class="expanded button-group">
                        <a
                            href="/"
                            class="alert button"
                        ><i class="fa fa-times"></i> RESET</a>
                        <input
                            type="submit"
                            class="button"
                            value="SEARCH"
                            >
                        </div>

                    </div>

                </div>

            </form>

            <?php if ($books->isEmpty()) { ?>

                <p>
                    There are no books available.
                </p>

            <?php } else { ?>

                <table class="table-list">
                    <thead>
                        <tr>
                            <th>
                                <i class="fa fa-book"></i> <?php echo $books->count(), ' ', \App\Helper::pluralSingular('Book', $books->count()); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($books->records() as $book) { ?>
                        <tr>
                            <td>
                                <?php echo $book->title; ?><br />
                                <small>
                                    <strong>Author(s):</strong> <?php echo $book->authors(); ?><br />
                                    <strong>Year:</strong> <?php echo $book->year; ?>, <strong>Price:</strong> <?php echo $book->price(); ?><br />
                                    <strong>Category:</strong> <?php echo $book->category; ?>, <strong>Cover types:</strong> <?php echo $book->covers(); ?><br />
                                    <strong>Available in:</strong> <?php echo $book->locations(); ?>, <strong>Languages:</strong> <?php echo $book->languages(); ?>
                                </small>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="center">

                    <?php echo $books->pagination(); ?>

                </div>

            <?php } ?>

        </div>

    </div>

<script src="./assets/js/dist/app.js"></script>
</body>
</html>