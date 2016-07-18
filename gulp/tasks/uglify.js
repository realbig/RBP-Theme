var $             = require( 'gulp-load-plugins' )();
var config        = require( '../util/loadConfig' ).javascript;
var gulp          = require( 'gulp' );
var sequence      = require( 'run-sequence' );
var notify        = require( 'gulp-notify' );
var fs            = require( 'fs' );
var pkg           = JSON.parse( fs.readFileSync( './package.json' ) );
var onError       = notify.onError( {
    title:    pkg.name,
    message:  '<%= error.name %> <%= error.message %>'   
} );

gulp.task( 'front-uglify', function() {

    return gulp.src( config.front.src )
        .pipe( $.plumber( { errorHandler: onError } ) )
        .pipe( $.sourcemaps.init() )
        .pipe( $.babel() )
        .pipe( $.concat( config.front.filename ) )
        .pipe( $.uglify() )
        .pipe( $.sourcemaps.write( '.' ) )
        .pipe( gulp.dest( config.dest.root ) )
        .pipe( $.plumber.stop() )
        .pipe( notify( {
            title: pkg.name,
            message: 'JS Complete'
        } ) );

} );

gulp.task( 'admin-uglify', function() {

    return gulp.src( config.admin.src )
        .pipe( $.plumber( { errorHandler: onError } ) )
        .pipe( $.sourcemaps.init() )
        .pipe( $.babel() )
        .pipe( $.concat( config.admin.filename ) )
        .pipe( $.uglify() )
        .pipe( $.sourcemaps.write( '.' ) )
        .pipe( gulp.dest( config.dest.root ) )
        .pipe( $.plumber.stop() )
        .pipe( notify( {
            title: pkg.name,
            message: 'Admin JS Complete'
        } ) );

} );

gulp.task( 'uglify', function( done ) {
    sequence( 'front-uglify', 'admin-uglify', done );
} );