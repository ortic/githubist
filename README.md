githubist
=========

githubist is an alternative to gist where your code snippets are pulled from a git repository. It was written because some code examples belong in the main repository where they can be fixed by multiple users while snippets on gist can only be managed by a single person.

Using githubist is simple, just embed a script like this in your site:

```html
<script src="http://githubist.ortic.com/punic/punic/examples/example.php"></script>
```

The first parameter "punic" is the user, the second "punic" the repository and everything after that the path to the file you wish to render.

You can see a working example in this documentation: [http://punic.github.io/](http://punic.github.io/)
