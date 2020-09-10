<?php

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    // Require local autoload file
    require_once __DIR__ . '/../vendor/autoload.php';
} else if (file_exists(__DIR__ . '/../../../autoload.php')) {
    // Require global autoload file
    require_once __DIR__ . '/../../../autoload.php';
}

// Define script name
$script = basename($argv[0]);

// Define default options
$options = [
    'input'   => '',
    'search'  => '',
    'replace' => '',
    'output'  => ''
];

// Define short options
$shortopts  = 'i:';
$shortopts .= 's:';
$shortopts .= 'r:';
$shortopts .= 'o:';

// Define long options
$longopts = ['input:', 'search:', 'replace:', 'output:'];

// Define required options
$required = ['input', 'search', 'replace'];

// Get all options
$opts = getopt($shortopts, $longopts);

// Merge short and long options
foreach ($opts as $key => $value) {
    switch ($key) {
        case 'i':
            $key = 'input';
            break;
        case 's':
            $key = 'search';
            break;
        case 'r':
            $key = 'replace';
            break;
        case 'o':
            $key = 'output';
            break;
    }

    $options[$key] = $value;
}

// Set whether we should show help message
$show_help = false;

// Validate required arguments
foreach ($options as $option => $value) {
    if (in_array($option, $required) && empty($value)) {
        $show_help = true;

        break;
    }
}

// Print help message if required any options are missing
if ($show_help) {
    fwrite(
        STDERR,
        'Usage: ' . $script . ' [options]' . PHP_EOL . PHP_EOL .
        'Options:' . PHP_EOL .
        '  --input, -i   Path to input file' . PHP_EOL .
        '  --search, -s  The value being searched for' . PHP_EOL .
        '  --replace, -r Replacement string' . PHP_EOL .
        '  --output, -o  Path to output file (optional, defaults to the standard output stream)' . PHP_EOL
    );

    exit;
}

// Check if input file exists
if (!file_exists($options['input'])) {
    // Print error and exit if the input file could not be found
    fwrite(
        STDERR,
        'Error: Could not find input file ' . $options['input'] . PHP_EOL
    );

    exit;
}

// Try to open input file
$input = @file_get_contents($options['input']);

if ($input === false) {
    // Print error and exit if input file can not be opened
    fwrite(
        STDERR,
        'Error: Could not open input file ' . $options['input'] . PHP_EOL
    );

    exit;
}

// Perform replacements
$output = SerializedSearchReplace::replace(
    $options['search'],
    $options['replace'],
    $input,
    $count
);

if (!empty($options['output'])) {
    // Try to create a file handle pointing to the specified output file
    if (!$handle = @fopen($options['output'], 'w')) {
        // Print error and exit if output file can not be opened or created
        fwrite(
            STDERR,
            'Error: Cannot open or create file ' . $options['output'] . PHP_EOL
        );

        exit;
    }

    // Try to write to the specified output file
    if (@fwrite($handle, $output) === false) {
        // Print error and exit if output file can not be written to
        fwrite(
            STDERR,
            'Error: Cannot write to file ' . $options['output'] . PHP_EOL
        );

        exit;
    }
} else {
    // Print replaced file data to the standard output stream
    fwrite(STDOUT, $output);
}

// Print the number of replacements performed
fwrite(
    STDERR,
    'Replaced ' . $count .
    ' instances of "' . $options['search'] .
    '" with "' . $options['replace'] .
    '"' . PHP_EOL
);
