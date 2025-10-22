def find_maximum(numbers):
    """
    Returns the largest number in a list.
    
    Args:
        numbers (list): A list of numeric values.
    
    Returns:
        int or float: The largest number in the list.
    """
    if not numbers:
        return None  # handle empty list
    
    max_num = numbers[0]
    for num in numbers:
        if num > max_num:
            max_num = num
    return max_num


# Example usage
data = [3, 7, 2, 9, 5]
print("Maximum value:", find_maximum(data))
