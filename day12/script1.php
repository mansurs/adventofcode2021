<?php

//$fileContent = explode("\n", file_get_contents('example3.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$graph = [];
foreach ($fileContent as $line) {
    $graph[] = explode('-', $line);
}

class Node {
    /** @var Node[] */
    public array $nodes;

    /** @var bool */
    public bool $once;

    public function __construct(public string $name)
    {
        $this->once = ctype_lower($name);
    }

    public function addTarget(Node $node) {
        if ($node->name === $this->name) {
            return;
        }
        if (!isset($this->nodes[$node->name])) {
            $this->nodes[$node->name] = $node;
        }
        if (!isset($node->nodes[$this->name])) {
            $node->nodes[$this->name] = $this;
        }
    }
}

$nodes = [];

$paths = [];
foreach ($graph as $p) {
    if (!isset($nodes[$p[0]])) {
        $nodeFrom = new Node($p[0]);
        $nodes[$nodeFrom->name] = $nodeFrom;
    }
    if (!isset($nodes[$p[1]])) {
        $nodeTo = new Node($p[1]);
        $nodes[$nodeTo->name] = $nodeTo;
    }
    $nodes[$p[0]]->addTarget($nodes[$p[1]]);
}

function findPaths(Node $currentNode, Node $startNode, Node $endNode, array $pathStack = []): array {
    $pathStack[] = $currentNode->name;
    $paths = [];
    foreach ($currentNode->nodes as $node) {
        if ($node->once && in_array($node->name, $pathStack)) {
            continue;
        }
        if ($node->name === $endNode->name) {
            $paths[] = [$currentNode->name, $node->name];
            continue;
        }
        $foundPaths = findPaths($node, $startNode, $endNode, $pathStack);
        foreach ($foundPaths as $path) {
            array_unshift($path, $currentNode->name);
            $paths[] = $path;
        }
    }
    return $paths;
}


function printMatrix($matrix) {
    foreach ($matrix as $row) {
        echo implode(",", $row) . "\n";
    }
}

$allPaths = findPaths($nodes['start'], $nodes['start'], $nodes['end']);

printMatrix($allPaths);

var_dump(count($allPaths));