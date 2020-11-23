/*!
 * Bootstrap's Gruntfile
 * http://getbootstrap.com
 * Copyright 2013-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

module.exports = function (grunt) {
	"use strict";

	// Force use of Unix newlines
	grunt.util.linefeed = "\n";

	// Project configuration.
	grunt.initConfig({
		banner:
			"/*!\n" +
			"Teste Eli\n" +
			//   ' * IASD Bootstrap v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
			//   ' * Copyright 2014-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
			//   ' * Licensed under <%= pkg.license.type %> (<%= pkg.license.url %>)\n' +
			" */\n",

		concat: {
			options: {
				banner: "<%= banner %>\n",
				stripBanners: false,
			},
			pa_scripts: {
				src: [
					"node_modules/@glidejs/glide/dist/glide.min.js",
					"scripts/*.js"
				],
				dest: "js/script.js",
			},
		},

		uglify: {
			options: {
				report: "min",
			},
			pa_scripts: {
				options: {
					banner: "<%= banner %>",
				},
				src: "<%= concat.pa_scripts.dest %>",
				dest: "js/script.min.js",
			},
		},

		compass: {
			dist: {
				options: {
					config: "config.rb",
				},
			},
		},

		watch: {
			scripts: {
				files: ["scripts/*.js"],
				tasks: ["concat", "uglify"],
				options: {
					spawn: false,
				},
			},
			sass: {
				files: ["scss/*.scss"],
				tasks: ["compass"],
				options: {
					spawn: false,
				},
			},
		},
	});

	// These plugins provide necessary tasks.
	require("load-grunt-tasks")(grunt);
	require("time-grunt")(grunt);

	grunt.registerTask("default", ["concat", "uglify", "compass"]);
};
