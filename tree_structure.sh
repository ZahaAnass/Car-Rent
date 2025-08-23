#!/bin/bash

# Simple Tree Structure Generator
# Usage: ./simple_tree.sh [directory] [output_file]

TARGET_DIR="${1:-.}"
OUTPUT_FILE="${2:-structure.txt}"

# Function to generate tree structure
generate_tree() {
    local dir="$1"
    local prefix="$2"
    
    # Get sorted list of items
    local items=($(ls -1 "$dir" 2>/dev/null | sort))
    local total=${#items[@]}
    
    for i in "${!items[@]}"; do
        local item="${items[i]}"
        local path="$dir/$item"
        local is_last=$((i == total - 1))
        
        # Skip hidden files except important ones
        if [[ "$item" =~ ^\..*$ ]] && [[ "$item" != ".env" ]] && [[ "$item" != ".env.example" ]] && [[ "$item" != ".gitattributes" ]]; then
            continue
        fi
        
        # Determine tree symbols
        if [[ $is_last -eq 1 ]]; then
            echo "${prefix}└── $item$([ -d "$path" ] && echo "/" || echo "")"
            local new_prefix="${prefix}    "
        else
            echo "${prefix}├── $item$([ -d "$path" ] && echo "/" || echo "")"
            local new_prefix="${prefix}│   "
        fi
        
        # Recursively process directories
        if [[ -d "$path" ]]; then
            # Special handling for vendor directory
            if [[ "$item" == "vendor" ]]; then
                echo "${new_prefix}├── autoload.php"
                echo "${new_prefix}└── [composer dependencies...]"
            # Special handling for img directory (show placeholder for many files)
            elif [[ "$item" == "img" ]]; then
                if [[ $(find "$path" -type f | wc -l) -gt 5 ]]; then
                    echo "${new_prefix}└── [various image files...]"
                else
                    generate_tree "$path" "$new_prefix"
                fi
            # Special handling for lib directory
            elif [[ "$item" == "lib" ]]; then
                if [[ $(find "$path" -type f | wc -l) -gt 10 ]]; then
                    echo "${new_prefix}└── [various library files...]"
                else
                    generate_tree "$path" "$new_prefix"
                fi
            else
                generate_tree "$path" "$new_prefix"
            fi
        fi
    done
}

# Main execution
main() {
    if [[ ! -d "$TARGET_DIR" ]]; then
        echo "Error: Directory '$TARGET_DIR' not found!"
        exit 1
    fi
    
    local dir_name=$(basename "$(realpath "$TARGET_DIR")")
    
    # Generate tree structure
    {
        echo "$dir_name/"
        generate_tree "$TARGET_DIR" ""
    } | tee "$OUTPUT_FILE"
    
    echo
    echo "Tree structure saved to: $OUTPUT_FILE"
}

# Show usage if help requested
if [[ "$1" == "-h" ]] || [[ "$1" == "--help" ]]; then
    echo "Usage: $0 [directory] [output_file]"
    echo ""
    echo "Examples:"
    echo "  $0                    # Current directory to structure.txt"
    echo "  $0 /path/to/project   # Specific directory to structure.txt"
    echo "  $0 . my_tree.txt      # Custom output file"
    exit 0
fi

# Run main function
main